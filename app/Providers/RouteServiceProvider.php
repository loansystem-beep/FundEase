<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();

        // Example: You can define custom route pattern filters here if needed
        // Route::pattern('slug', '[A-Za-z0-9-_]+');
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapWebRoutes();
        $this->mapApiRoutes();
        // If you have additional routes, you can add them here
    }

    /**
     * Define the "web" routes for the application.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)  // Set namespace for controllers
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')  // Prefix for API routes
            ->middleware('api')  // Apply the 'api' middleware
            ->namespace($this->namespace)  // Set namespace for API controllers
            ->group(base_path('routes/api.php'));
    }

    /**
     * You can add more custom route maps if needed
     * For example, if you have admin routes:
     *
     * protected function mapAdminRoutes()
     * {
     *     Route::prefix('admin') 
     *         ->middleware('admin') 
     *         ->namespace($this->namespace)
     *         ->group(base_path('routes/admin.php'));
     * }
     */
}
