<?php namespace Sociavel\Providers;

use Sociavel\Sociavel;
use Illuminate\Support\ServiceProvider;

class SociavelServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerSocialMedia();

		$this->app->alias('sv', 'Sociavel\Sociavel');
	}

	/**
	 * Register the HTML builder instance.
	 *
	 * @return void
	 */
	protected function registerSocialMedia()
	{
		$this->app->bindShared('sv', function($app)
		{
			return new Sociavel($app);
		});
	}


	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('sv', 'Sociavel\Sociavel');
	}

}
