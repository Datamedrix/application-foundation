<?php
/**
 * ----------------------------------------------------------------------------
 * This code is part of an application or library developed by Datamedrix and
 * is subject to the provisions of your License Agreement with
 * Datamedrix GmbH.
 *
 * @copyright (c) 2018 Datamedrix GmbH
 * ----------------------------------------------------------------------------
 * @author Christian Graf <c.graf@datamedrix.com>
 */

declare(strict_types=1);

namespace DMX\Application;

use DMX\Application\Http\ViewComposers\DefaultComposer;
use DMX\Application\Http\ViewComposers\ProfileComposer;
use Illuminate\Contracts\View\Factory as ViewFactoryContract;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param ViewFactoryContract $view
     *
     * @return void
     */
    public function boot(ViewFactoryContract $view)
    {
        // Define route loading location(s)
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Define view loading location(s)
        $this->loadViewsFrom(__DIR__ . '/../resources/views/about', 'about');
        $this->loadViewsFrom(__DIR__ . '/../resources/views/layouts', 'layouts');

        // Register view composers
        $view->composer('*', DefaultComposer::class);
        $view->composer('*', ProfileComposer::class);

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'app');

        // Define publishes...
        $this->publishes([
            __DIR__ . '/../resources/views/about' => resource_path('views/vendor/about'),
            __DIR__ . '/../resources/views/layouts' => resource_path('views/vendor/layouts'),
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/app'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function provides(): array
    {
        return [];
    }
}
