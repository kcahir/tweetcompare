<?php

/**
* Part of the Tweetcompare package
*
* Kieran Cahir - 9/9/13 (kcahir@ymail.com)
*/

namespace Kcahir\Tweetcompare\Repositories;

/**
* ServiceRespositoryInterface interface
*/
Interface ServiceRepositoryInterface
{

    /**
    *
    */
	public function load($screen_name);

    /**
    *
    */
    public function getErrors();

    /**
    *
    */
    public function getSpellingErrorFrequency();

    /**
    *
    */
	public function getMaxDistance();

    /**
    *
    */
	public function getAverageTweetsPerWorkday();

}
