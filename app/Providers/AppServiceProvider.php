<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Providers;

use Carbon\Carbon;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Navigation\Factory;
use App\Repositories\CommentRepository;
use App\Repositories\EventRepository;
use App\Repositories\PageRepository;
use App\Repositories\PostRepository;
use App\Subscribers\CommandSubscriber;
use App\Subscribers\NavigationSubscriber;
use Illuminate\Support\ServiceProvider;

/**
 * This is the app service provider class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupBlade();
//        App::setLocale('');
        Carbon::setLocale(config('app.locale'));
        require __DIR__.'/../assets.php';
        require __DIR__.'/../listeners.php';
    }

    /**
     * Setup the blade compiler class.
     *
     * @return void
     */
    protected function setupBlade()
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $this->app['view']->share('__navtype', 'default');

        $blade->extend(function ($value, $compiler) {
            $pattern = $compiler->createMatcher('navtype');
            $replace = '$1<?php $__navtype = $2; ?>';

            return preg_replace($pattern, $replace, $value);
        });

        $blade->extend(function ($value, $compiler) {
            $pattern = $compiler->createPlainMatcher('navigation');
            $replace = '$1<?php echo \App\Facades\NavigationFactory::make($__navtype); ?>$2';

            return preg_replace($pattern, $replace, $value);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerNavigationFactory();

        $this->registerCommentRepository();
        $this->registerEventRepository();
        $this->registerPageRepository();
        $this->registerPostRepository();

        $this->registerCommandSubscriber();
        $this->registerNavigationSubscriber();

        $this->registerCommentController();
        $this->registerPageController();
    }

    /**
     * Register the navigation factory class.
     *
     * @return void
     */
    protected function registerNavigationFactory()
    {
        $this->app->singleton('navfactory', function ($app) {
            $credentials = $app['credentials'];
            $navigation = $app['navigation'];
            $name = $app['config']['core.name'];
            $property = $app['config']['cms.nav'];
            $inverse = $app['config']['theme.inverse'];

            return new Factory($credentials, $navigation, $name, $property, $inverse);
        });

        $this->app->alias('navfactory', 'App\Navigation\Factory');
    }

    /**
     * Register the comment repository class.
     *
     * @return void
     */
    protected function registerCommentRepository()
    {
        $this->app->singleton('commentrepository', function ($app) {
            $model = $app['config']['cms.comment'];
            $comment = new $model();

            $validator = $app['validator'];

            return new CommentRepository($comment, $validator);
        });

        $this->app->alias('commentrepository', 'App\Repositories\CommentRepository');
    }

    /**
     * Register the event repository class.
     *
     * @return void
     */
    protected function registerEventRepository()
    {
        $this->app->singleton('eventrepository', function ($app) {
            $model = $app['config']['cms.events'];
            $event = new $model();

            $validator = $app['validator'];

            return new EventRepository($event, $validator);
        });

        $this->app->alias('eventrepository', 'App\Repositories\EventRepository');
    }

    /**
     * Register the page repository class.
     *
     * @return void
     */
    protected function registerPageRepository()
    {
        $this->app->singleton('pagerepository', function ($app) {
            $model = $app['config']['cms.page'];
            $page = new $model();

            $validator = $app['validator'];

            return new PageRepository($page, $validator);
        });

        $this->app->alias('pagerepository', 'App\Repositories\PageRepository');
    }

    /**
     * Register the post repository class.
     *
     * @return void
     */
    protected function registerPostRepository()
    {
        $this->app->singleton('postrepository', function ($app) {
            $model = $app['config']['cms.post'];
            $post = new $model();

            $validator = $app['validator'];

            return new PostRepository($post, $validator);
        });

        $this->app->alias('postrepository', 'App\Repositories\PostRepository');
    }

    /**
     * Register the command subscriber class.
     *
     * @return void
     */
    protected function registerCommandSubscriber()
    {
        $this->app->singleton('App\Subscribers\CommandSubscriber', function ($app) {
            $pagerepository = $app['pagerepository'];

            return new CommandSubscriber($pagerepository);
        });
    }

    /**
     * Register the navigation subscriber class.
     *
     * @return void
     */
    protected function registerNavigationSubscriber()
    {
        $this->app->singleton('App\Subscribers\NavigationSubscriber', function ($app) {
            $navigation = $app['navigation'];
            $credentials = $app['credentials'];
            $pagerepository = $app['pagerepository'];
            $blogging = $app['config']['cms.blogging'];
            $events = $app['config']['cms.event'];

            return new NavigationSubscriber(
                $navigation,
                $credentials,
                $pagerepository,
                $blogging,
                $events
            );
        });
    }

    /**
     * Register the comment controller class.
     *
     * @return void
     */
    protected function registerCommentController()
    {
        $this->app->bind('App\Http\Controllers\CommentController', function ($app) {
            $throttler = $app['throttle']->get($app['request'], 1, 10);

            return new CommentController($throttler);
        });
    }

    /**
     * Register the page controller class.
     *
     * @return void
     */
    protected function registerPageController()
    {
        $this->app->bind('App\Http\Controllers\PageController', function ($app) {
            $path = $app['config']['core.home'];

            return new PageController($path);
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
            'navfactory',
            'commentrepository',
            'eventrepository',
            'fileprovider',
            'folderprovider',
            'pagerepository',
            'postrepository',
        ];
    }
}
