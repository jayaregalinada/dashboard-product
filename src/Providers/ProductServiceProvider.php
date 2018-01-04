<?php

namespace Jag\Dashboard\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Jag\Dashboard\Traits\CreateMigrationTrait;

class ProductServiceProvider extends ServiceProvider
{
    use CreateMigrationTrait;

    /**
     * @var boolean
     */
    protected $defer = false;

    /**
     * @return void
     */
    public function boot()
    {
        $this->mergeConfig();
        $this->registerRoutes();
        $this->publishConfig();
        $this->publishMigrations();
    }

    /**
     * @return void
     */
    public function register()
    {

    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['dashboard.product'];
    }

    /**
     * Merge the configuration.
     *
     * @return void
     */
    protected function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config.php', 'dashboard.product'
        );
    }

    protected function publishConfig()
    {
        $this->publishes([
            __DIR__.'/../config.php' => config_path('dashboard/product.php')
        ]);
    }

    protected function registerRoutes()
    {
        Route::prefix(config('dashboard.dashboard.uri'))
             ->middleware(['web', 'auth'])
             ->name(config('dashboard.dashboard.uri'). ':')
             ->namespace('Jag\Dashboard\Controllers')
             ->group(__DIR__ . '/../routes/web.php');
    }

    protected function publishMigrations()
    {
        $timestamp = new Carbon();

        foreach([
            'products',
            'categories',
            'images',
            'tags'
        ] as $migration) {
            $this->createMigration($migration, $timestamp->addSecond()->format('Y_m_d_His'), __DIR__);
        }
    }
}
