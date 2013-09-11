<?php

/**
* Part of the Tweetcompare package
*
* Kieran Cahir - 9/9/13 (kcahir@ymail.com)
*/

namespace Kcahir\Tweetcompare\Tests;


use \Kcahir\Tweetcompare\Controllers\TweetcompareController;

class TweetcompareControllerTest extends \TestCase {

	public function testPostAccountFail(){

		$mock = $this->getMock('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface');

		$this->app->instance('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface', $mock);

		$mock->expects($this->once())->method('load')->will($this->returnValue(FALSE));
		$mock->expects($this->once())->method('getErrors');

		/* expect these NOT to be called */
		$mock->expects($this->never())->method('getMaxDistance');
		$mock->expects($this->never())->method('getAverageTweetsPerWorkday');
		$mock->expects($this->never())->method('getSpellingErrorFrequency');

		$controller = new TweetcompareController($mock);
		$response = $controller->addAccount();
	}

	public function testPostAccountSuccess(){

		$mock = $this->getMock('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface');

		$this->app->instance('\Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface', $mock);

		$mock->expects($this->once())->method('load')->will($this->returnValue(TRUE));
		$mock->expects($this->never())->method('getErrors');

		/* expect these to be called */
		$mock->expects($this->once())->method('getMaxDistance');
		$mock->expects($this->once())->method('getAverageTweetsPerWorkday');
		$mock->expects($this->once())->method('getSpellingErrorFrequency');

		$controller = new TweetcompareController($mock);
		$response = $controller->addAccount();
	}
}