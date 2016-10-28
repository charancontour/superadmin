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
        	__DIR__.'/css' => base_path('public/css/superadmin/'),
        	__DIR__.'/js' => base_path('public/js/superadmin/'),
        	__DIR__.'/img' => base_path('public/img/superadmin/')
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
