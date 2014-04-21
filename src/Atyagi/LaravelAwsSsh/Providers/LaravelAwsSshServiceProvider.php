<?php namespace Atyagi\LaravelAwsSsh\Providers;

use Atyagi\LaravelAwsSsh\AWS;
use Atyagi\LaravelAwsSsh\Commands\EC2TailCommand;
use Atyagi\LaravelAwsSsh\Commands\ElasticBeanstalkTailCommand;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Aws\Common\Aws as ProvidedAWS;

class LaravelAwsSshServiceProvider extends ServiceProvider {

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
        $namespace = 'laravel-aws-ssh';
        $path = __DIR__ . '/../../..';
		$this->package('atyagi/laravel-aws-ssh', $namespace, $path);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->app['command.eb.tail'] = $this->app->share(function($app)
        {
            $providedAws = $this->createProvidedAws();
            $aws = new AWS($providedAws);
            return new ElasticBeanstalkTailCommand($app, $aws);
        });
        $this->commands('command.eb.tail');
        $this->app['command.ec2.tail'] = $this->app->share(function($app)
        {
            $providedAws = $this->createProvidedAws();
            $aws = new AWS($providedAws);
            return new EC2TailCommand($app, $aws);
        });
        $this->commands('command.ec2.tail');
	}

    private function createProvidedAws()
    {
        $accessKey = $this->app->make('config')->get('laravel-aws-ssh::aws.access_key');
        $secretKey = $this->app->make('config')->get('laravel-aws-ssh::aws.secret_key');
        $region = $this->app->make('config')->get('laravel-aws-ssh::aws.region', 'us-east-1');
        $providedAws = ProvidedAWS::factory(
            array(
                'key' => $accessKey,
                'secret' => $secretKey,
                'region' => $region,
            )
        );

        return $providedAws;
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
