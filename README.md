Tweetcompare
============

Compare user tweet statistics in Laravel 4

You need to create a Twitter application and create your access token in the [developer console](https://dev.twitter.com/).


## Installation

You can start with `composer create-project laravel/laravel --prefer-dist` to [install laravel](http://laravel.com/docs/installation/).

Add `kcahir/tweetcompare` to `composer.json`.

    "kcahir/tweetcompare": "dev-master"

Run `composer update` to pull down the latest version of Tweetcompare.

Now open up `app/config/app.php` and add the service provider to your `providers` array.

    'providers' => array(
    	'Kcahir\Tweetcompare\TweetcompareServiceProvider',
	    'Toin0u\Geotools\GeotoolsServiceProvider',
        'Thujohn\Twitter\TwitterServiceProvider',
    )

Now add the alias.

    'aliases' => array(
        'Twitter' => 'Thujohn\Twitter\TwitterFacade',
        'Geotools' => 'Toin0u\Geotools\GeotoolsFacade',
    )

Run `php artisan dump-autoload`

## Assets

Run `php artisan asset:publish kcahir/tweetcompare`

## Configuration

Run `php artisan config:publish thujohn/twitter` and modify the config file at `app/config/packages/thujohn/twitter/config.php` with your own information.

## Final Step

Go to `app/routes.php` and remove the default route shown.

Now navigate to the `public/` directory in your browser.
