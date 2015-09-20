<?php

/*
 * This file is part of Laravel Credentials.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Providers;

use App\Credentials;
use Illuminate\Contracts\View\Factory as View;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use SebastianBergmann\Diff\Differ;

/**
 * This is the credentials service provider class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class CredentialsServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupPackage();

        $this->setupBlade($this->app->view);

        $this->setupRoutes($this->app->router);
    }

    /**
     * Setup the package.
     *
     * @return void
     */
    protected function setupPackage()
    {
        $configuration = realpath(__DIR__.'/../../config/credentials.php');
        $migrations = realpath(__DIR__.'/../migrations');

        $this->publishes([
            $configuration => config_path('credentials.php'),
            $migrations    => base_path('database/migrations'),
        ]);

        $this->mergeConfigFrom($configuration, 'credentials');

        $this->loadViewsFrom(realpath(__DIR__.'/../views'), 'credentials');
    }

    /**
     * Setup the blade compiler class.
     *
     * @param \Illuminate\Contracts\View\Factory $view
     *
     * @return void
     */
    protected function setupBlade(View $view)
    {
        $blade = $view->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function ($value, $compiler) {
            $pattern = $compiler->createMatcher('auth');
            $replace = '$1<?php if (\App\Facades\Credentials::check() && \App\Facades\Credentials::hasAccess$2): ?>';

            return preg_replace($pattern, $replace, $value);
        });

        $blade->extend(function ($value, $compiler) {
            $pattern = $compiler->createPlainMatcher('endauth');
            $replace = '$1<?php endif; ?>$2';

            return preg_replace($pattern, $replace, $value);
        });
    }

    /**
     * Setup the routes.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        require __DIR__.'/../Http/filters.php';

        $router->group(['namespace' => 'App\Http\Controllers'], function (Router $router) {
            require __DIR__.'/../Http/routes.php';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDiffer();
        $this->registerRevisionRepository();
        $this->registerUserRepository();
        $this->registerGroupRepository();
        $this->registerCredentials();

        $this->registerAccountController();
        $this->registerLoginController();
        $this->registerRegistrationController();
        $this->registerResetController();
        $this->registerActivationController();
        $this->registerUserController();
    }

    /**
     * Register the differ class.
     *
     * @return void
     */
    protected function registerDiffer()
    {
        $this->app->singleton('differ', function ($app) {
            return new Differ();
        });

        $this->app->alias('differ', 'SebastianBergmann\Diff\Differ');
    }

    /**
     * Register the revision repository class.
     *
     * @return void
     */
    protected function registerRevisionRepository()
    {
        $this->app->singleton('revisionrepository', function ($app) {
            $model = $app['config']['credentials.revision'];
            $revision = new $model();

            $validator = $app['validator'];

            return new \App\Repositories\RevisionRepository($revision, $validator);
        });

        $this->app->alias('revisionrepository', 'App\Repositories\RevisionRepository');
    }

    /**
     * Register the user repository class.
     *
     * @return void
     */
    protected function registerUserRepository()
    {
        $this->app->singleton('userrepository', function ($app) {
            $model = $app['config']['sentry.users.model'];
            $user = new $model();

            $validator = $app['validator'];

            return new \App\Repositories\UserRepository($user, $validator);
        });

        $this->app->alias('userrepository', 'App\Repositories\UserRepository');
    }

    /**
     * Register the group repository class.
     *
     * @return void
     */
    protected function registerGroupRepository()
    {
        $this->app->singleton('grouprepository', function ($app) {
            $model = $app['config']['sentry.groups.model'];
            $group = new $model();

            $validator = $app['validator'];

            return new \App\Repositories\GroupRepository($group, $validator);
        });

        $this->app->alias('grouprepository', 'App\Repositories\GroupRepository');
    }

    /**
     * Register the credentials class.
     *
     * @return void
     */
    protected function registerCredentials()
    {
        $this->app->singleton('credentials', function ($app) {
            $sentry = $app['sentry'];
            $decorator = $app->make('McCool\LaravelAutoPresenter\PresenterDecorator');

            return new Credentials($sentry, $decorator);
        });

        $this->app->alias('credentials', 'App\Credentials');
    }

    /**
     * Register the account controller class.
     *
     * @return void
     */
    protected function registerAccountController()
    {
        $this->app->bind('App\Http\Controllers\AccountController', function ($app) {
            return new \App\Http\Controllers\AccountController();
        });
    }

    /**
     * Register the login controller class.
     *
     * @return void
     */
    protected function registerLoginController()
    {
        $this->app->bind('App\Http\Controllers\LoginController', function ($app) {
            $throttler = $app['throttle']->get($app['request'], 10, 10);

            return new \App\Http\Controllers\LoginController($throttler);
        });
    }

    /**
     * Register the registration controller class.
     *
     * @return void
     */
    protected function registerRegistrationController()
    {
        $this->app->bind('App\Http\Controllers\RegistrationController', function ($app) {
            $throttler = $app['throttle']->get($app['request'], 5, 30);

            return new \App\Http\Controllers\RegistrationController($throttler);
        });
    }

    /**
     * Register the reset controller class.
     *
     * @return void
     */
    protected function registerResetController()
    {
        $this->app->bind('App\Http\Controllers\ResetController', function ($app) {
            $throttler = $app['throttle']->get($app['request'], 5, 30);

            return new \App\Http\Controllers\ResetController($throttler);
        });
    }

    /**
     * Register the resend controller class.
     *
     * @return void
     */
    protected function registerActivationController()
    {
        $this->app->bind('App\Http\Controllers\ActivationController', function ($app) {
            $throttler = $app['throttle']->get($app['request'], 5, 30);

            return new \App\Http\Controllers\ActivationController($throttler);
        });
    }

    /**
     * Register the user controller class.
     *
     * @return void
     */
    protected function registerUserController()
    {
        $this->app->bind('App\Http\Controllers\UserController', function ($app) {
            return new \App\Http\Controllers\UserController();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return string[]
     */
    public function provides()
    {
        return [
            'differ',
            'revisionrepository',
            'userrepository',
            'grouprepository',
            'credentials',
        ];
    }
}
