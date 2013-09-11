<?php

/**
* Part of the Tweetcompare package
*
* Kieran Cahir - 9/9/13 (kcahir@ymail.com)
*/

namespace Kcahir\Tweetcompare\Tests;


use App;

class TweetcompareTest extends \TestCase {


	/**
	 * Test the App is responding and has correct Title
	 *
	 */
	public function testIsLive()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
		$this->assertCount(1, $crawler->filter('title:contains("Twitter Compare")'));
	}

	/**
	 * Test the API responds with JSON formatted data
	 *
	 */
	public function testApiResponse()
	{
		$crawler = $this->client->request('GET', 'account/add');

		$response = $this->client->getResponse();

	    json_decode($response->getContent());

	    $this->assertTrue( json_last_error() == JSON_ERROR_NONE );
	}

	/**
	 * Test the Interface is bound to the Implementation
	 *
	 */
	public function testInterfaceBindsToImplementation()
	{
		$serviceRepositoryInterface = App::make('Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface');

		$this->assertInstanceOf('Kcahir\Tweetcompare\Repositories\TweetsRepository', $serviceRepositoryInterface);
	}
}