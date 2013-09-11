tweetcompare
============

Twitter Statistics for Laravel 4

You need to create an application and create your access token in the [developer console](https://dev.twitter.com/).


## Installation

Add `kcahir/tweetcompare` to `composer.json`.

    "kcahir/tweetcompare": "dev-master"

Run `composer update` to pull down the latest version of Twitter.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
	    'Toin0u\Geotools\GeotoolsServiceProvider',
		'Kcahir\Tweetcompare\TweetcompareServiceProvider'
        'Thujohn\Twitter\TwitterServiceProvider',
    )

Now add the alias.

    'aliases' => array(
        'Twitter' => 'Thujohn\Twitter\TwitterFacade',
        'Geotools' => 'Toin0u\Geotools\GeotoolsFacade',
    )

## Assets

Run `php artisan asset:publish kcahir/tweetcompare`

## Configuration

Run `php artisan config:publish thujohn/twitter` and modify the config file with your own informations.

## Final Step

Go to `app/routes.php` and remove the default route shown.

Now navigate to the 'public/' directory in your browser.