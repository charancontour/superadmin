<?php namespace SuperAdmin;

use Illuminate\Support\ServiceProvider;

class SuperAdminServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->publishes([
        	__DIR__.'/views' => base_path('resources/views/vendor/superadmin/'),
    	]);
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		include __DIR__.'/routes.php';
    $this->app->make('SuperAdmin\SuperAdminController');
	}

}
