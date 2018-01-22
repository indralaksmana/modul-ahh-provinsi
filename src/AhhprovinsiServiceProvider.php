<?php namespace Satudata\Ahhprovinsi;

use Illuminate\Support\ServiceProvider;
use Satudata\Ahhprovinsi\Console\Commands\AhhprovinsiCommand;

/**
 * The AhhprovinsiServiceProvider class
 *
 * @package Satudata\Ahhprovinsi
 * @author  MKI <info@mkitech.net>
 */
class AhhprovinsiServiceProvider extends ServiceProvider
{

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
        // Bootstrap handles
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ahhprovinsi', function ($app) {
            return new Ahhprovinsi;
        });

        $this->app->singleton('command.ahhprovinsi', function ($app) {
            return new AhhprovinsiCommand;
        });

        $this->commands('command.ahhprovinsi');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'ahhprovinsi',
            'command.ahhprovinsi',
        ];
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('ahhprovinsi.php');

        $this->mergeConfigFrom($packageConfigPath, 'ahhprovinsi');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'config');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'ahhprovinsi');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/ahhprovinsi'),
        ], 'lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/assets/components';
        
        $this->publishes([
            $packageViewsPath => resource_path('assets/components'),
        ], 'views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => public_path('vendor/ahhprovinsi'),
        ], 'public');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'migrations');
    }
}
