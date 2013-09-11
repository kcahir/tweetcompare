<?php namespace Kcahir\Tweetcompare;

use Illuminate\Support\ServiceProvider;

class TweetcompareServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('kcahir/tweetcompare');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		include __DIR__ .'/routes.php';

		// $this->app['tweetcompare'] = $this->app->share(function($app)
		// {
		// 	return new Tweetcompare;
		// });

		$this->app->bind('Kcahir\Tweetcompare\Repositories\ServiceRepositoryInterface', 'Kcahir\Tweetcompare\Repositories\TweetsRepository');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('tweetcompare');
	}

}