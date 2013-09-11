<?php

/**
* Part of the Tweetcompare package
*
* Kieran Cahir - 9/9/13 (kcahir@ymail.com)
*/

namespace Kcahir\Tweetcompare\Controllers;

use BaseController;
use Response;
use View;
use Twitter;
use Geotools;
use Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface;

/**
* TweetcompareConotroller class.
*/
class TweetcompareController extends BaseController {

    protected $tweets;

    /**
     * Initializer.
     *
     * @return void
     */
    public function __construct(ServiceRepositoryInterface $tweets)
    {
        $this->tweets = $tweets;
    }

    /**
     * Show the homepage.
     *
     * @return Response
     */
    public function index()
    {
       return View::make('tweetcompare::default.home');
    }


    /**
     * Process an account.
     *
     * @params string $screen_name user's twitter handle
     *
     * @return Response
     */
    public function addAccount($screen_name = "")
    {
        if (!$this->tweets->load($screen_name)) {
            return Response::json($this->tweets->getErrors());
        }

        $response = array(
            "max_distance" => $this->tweets->getMaxDistance(),
            "tweets_per_workday" => $this->tweets->getAverageTweetsPerWorkday(),
            "spelling_frequency" => $this->tweets->getSpellingErrorFrequency(),
            );

        return Response::json($response);
    }
}
