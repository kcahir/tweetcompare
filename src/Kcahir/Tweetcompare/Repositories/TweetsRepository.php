<?php

/**
* Part of the Tweetcompare package
*
* Kieran Cahir - 9/9/13 (kcahir@ymail.com)
*/

namespace Kcahir\Tweetcompare\Repositories;

use Twitter;
use Geotools;
use Kcahir\Tweetcompare\Parser;

/**
* TweetsRepository class.
*/
class TweetsRepository implements ServiceRepositoryInterface
{

	protected $error;

	protected $timeline;
	protected $tweetBody = array();
	protected $coords = array();
	protected $workdays = array("Monday","Tuesday","Wednesday","Thursday","Friday");
	protected $limits = array(
	    "Lower"=>"09:00",
	    "Upper"=>"17:30",
	    );
	protected $earliestTweet = 0;
	protected $recentTweet = 0;
	protected $tweetsAtWorkork = 0;
	protected $daysWorked = 0;
	protected $avgWorkTweets = 0;
	protected $maxDistance = 0;
	protected $numLocations = 0;

	protected $spellingCorrections = 0;
	protected $totalWordsCounted = 0;

    /**
    * Call twitter api and initialize timeline.
    *
    * @params string $screen_name user's twitter handle
    *
    * @return bool
    */
	public function load($screen_name="")
	{
		$this->timeline = Twitter::getUserTimeline(
		    array(
		        'screen_name' => $screen_name,
		        'count' => 200,
		        'exclude_replies' => true,
		        'include_rts' => false,
		        ));

		/* some twitter error responses give different result object */
		if (isset($this->timeline->errors) && count($this->timeline->errors)) {
			
		    $this->error = $this->timeline->errors;

		    return false;
		    
		} elseif (isset($this->timeline->error)) {
			
		    $this->error = array(array("message"=>$this->timeline->error));

		    return false;
		    
		} else {

			$this->processTweets();

			return true;
		}
	}

	/**
	* Return error response
	*
	* @return array
	*/
	public function getErrors(){
		return $this->error;
	}

	/**
	* Get the spelling mistake frequency, as a percentage of the total word count
	*
	* @return float
	*/
	public function getSpellingErrorFrequency()
	{

		$ratio = ($this->totalWordsCounted > 0) ?
				$this->spellingCorrections / $this->totalWordsCounted : 0;

		return round($ratio*100, 2);
	}

    /**
    * Get the maximum distance (km) between any two tweets, rounded to 2 decimal points
    *
    * @return float
    */
	public function getMaxDistance()
	{
		return round($this->maxDistance/1000, 2);
	}

    /**
    * Get the average tweets per working day, rounded to 3 decimal points
    *
    * @return float
    */
	public function getAverageTweetsPerWorkday()
	{
		return round($this->avgWorkTweets, 3);
	}

	/**
	* Iterate over returned tweets and set some instance variables.
	*/
	protected function processTweets()
	{
		$this->earliestTweet = time();

		foreach($this->timeline as $key => $value) {

		    $created = strtotime($this->timeline[$key]->created_at);
		    $day = Date("l", $created);
		    $time = Date("H:i", $created);

		    /* find earliest and latest tweets */
		    if ( $this->earliestTweet > $created ) {
		        $this->earliestTweet = $created;
		    }
		    if ( $this->recentTweet < $created ) {
		        $this->recentTweet = $created;
		    }
		    if (in_array($day, $this->workdays)) {

		        /* if within working hours / 9 - 5.30 */
		        if (strtotime("25-12-2013 ".$time) > strtotime("25-12-2013 ".$this->limits["Lower"]) &&
		                strtotime("25-12-2013 ".$time) < strtotime("25-12-2013 ".$this->limits["Upper"])) {
		            $this->tweetsAtWorkork ++;
		        }
		    }

		    /* extract geo location data if exists */
		    if (isset($this->timeline[$key]->geo->coordinates[1])) {
		        $this->coords[] = array(
		            $this->timeline[$key]->geo->coordinates[0],
		            $this->timeline[$key]->geo->coordinates[1]
		        );
		    }

		    $this->tweetBody[] = $this->timeline[$key]->text;
		}

		/* Finish processing by calculating some stats */
		$this->calculateSpellingErrorRatio();
		$this->calculateMaxDistance();
		$this->calculateAverageTweetsPerWorkday();
	}

    /**
    * Determine word count to spelling mistake ratio
    */
	protected function calculateSpellingErrorRatio()
	{

		$parser = new Parser();

		/* Set sample size to 10 tweets or less. */
		$sample_size = (count($this->tweetBody) > 10) ? 10 : count($this->tweetBody);

		/* Find 10 or less random tweets from total to test for spelling mistakes. */
		for ($i=0; $i < $sample_size; $i++) {

			$tweet = array_rand($this->tweetBody);

			$mistakes = $parser->parse($this->tweetBody[$tweet]);

			$this->totalWordsCounted += str_word_count($this->tweetBody[$tweet], 0);
			$this->spellingCorrections += count($mistakes['corrections']);

			/* Prevent same tweet from being chosen again. */
			unset($this->tweetBody[$tweet]);
		}
	}

    /**
    * Calculate furthest disance spanned between any two tweets.
    */
	protected function calculateMaxDistance()
	{
		$this->numLocations = count($this->coords);
		
		for ($i = 0; $i < $this->numLocations - 1; $i++) {
			
			$coordA = Geotools::coordinate($this->coords[$i]);
			
		    for ($j = $i + 1; $j < $this->numLocations; $j++) {
		        $coordB = Geotools::coordinate($this->coords[$j]);
		        $dist = Geotools::distance()->setFrom($coordA)->setTo($coordB);
		        $this->maxDistance = ($dist->flat() > $this->maxDistance) ? $dist->flat() : $this->maxDistance;
		    }
		}
	}

    /**
	* Calculate number of working days between earliest and most recent tweets.
	*
	* @return int
	*/
	protected function calculateDaysWorked()
	{
		$daysWorked = 0;
		for ($tweet = $this->earliestTweet; $tweet <= $this->recentTweet; $tweet += (24 * 60 * 60)) {
		    if (in_array(Date("l", $tweet), $this->workdays)) {
		        $daysWorked++;
		    }
		}

		return $daysWorked;
	}

    /**
    * Calculate average tweets sent per working day, between 9:00am to 5:30pm.
    * Total number of working days is calculated from earliest tweet in sample to the most recent.
    */
	protected function calculateAverageTweetsPerWorkday()
	{
		$daysWorked = $this->calculateDaysWorked();
		$this->avgWorkTweets = ($daysWorked > 0) ? $this->tweetsAtWorkork / $daysWorked : 0;
	}

}
