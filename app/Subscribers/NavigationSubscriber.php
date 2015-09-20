<?php

namespace App\Subscribers;

use App\Repositories\PageRepository;
use App\Credentials;
use App\Navigation\Navigation;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Config;

/**
 * This is the navigation subscriber class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class NavigationSubscriber
{
    /**
     * The navigation instance.
     *
     * @var \GrahamCampbell\Navigation\Navigation
     */
    protected $navigation;

    /**
     * The credentials instance.
     *
     * @var \GrahamCampbell\Credentials\Credentials
     */
    protected $credentials;

    /**
     * The page repository instance.
     *
     * @var \App\Repositories\PageRepository
     */
    protected $pagerepository;

    /**
     * The blogging flag.
     *
     * @var bool
     */
    protected $blogging;

    /**
     * The events flag.
     *
     * @var bool
     */
    protected $events;

    /**
     * The cloudflare flag.
     *
     * @var bool
     */
    protected $cloudflare;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\Navigation\Navigation                    $navigation
     * @param \GrahamCampbell\Credentials\Credentials                  $credentials
     * @param \App\Repositories\PageRepository $pagerepository
     * @param bool                                                     $blogging
     * @param bool                                                     $events
     * @param bool                                                     $cloudflare
     *
     * @return void
     */
    public function __construct(
        Navigation $navigation,
        Credentials $credentials,
        PageRepository $pagerepository,
        $blogging = false,
        $events = false,
        $cloudflare = false
    ) {
        $this->navigation = $navigation;
        $this->credentials = $credentials;
        $this->pagerepository = $pagerepository;
        $this->blogging = $blogging;
        $this->events = $events;
        $this->cloudflare = $cloudflare;
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(
            'navigation.main',
            'App\Subscribers\NavigationSubscriber@onNavigationMainFirst',
            8
        );
        $events->listen(
            'navigation.main',
            'App\Subscribers\NavigationSubscriber@onNavigationMainSecond',
            5
        );
        $events->listen(
            'navigation.main',
            'App\Subscribers\NavigationSubscriber@onNavigationMainThird',
            2
        );
        $events->listen(
            'navigation.bar',
            'App\Subscribers\NavigationSubscriber@onNavigationBarFirst',
            8
        );
        $events->listen(
            'navigation.bar',
            'App\Subscribers\NavigationSubscriber@onNavigationBarSecond',
            5
        );
        $events->listen(
            'navigation.bar',
            'App\Subscribers\NavigationSubscriber@onNavigationBarThird',
            2
        );
    }

    /**
     * Handle a navigation.main event first.
     *
     * @return void
     */
    public function onNavigationMainFirst()
    {
        // add the blog
        if (Config::get('cms.blogging')) {
            $this->navigation->addToMain(
                ['title' => trans('navigation.posts'), 'slug' => 'content/posts', 'icon' => 'book']
            );
        }

        // add the events
        if (Config::get('cms.events')) {
            $this->navigation->addToMain(
                ['title' => trans('navigation.events'), 'slug' => 'events', 'icon' => 'calendar']
            );
        }
    }

    /**
     * Handle a navigation.main event second.
     *
     * @return void
     */
    public function onNavigationMainSecond()
    {
        // get the pages
        $pages = $this->pagerepository->navigation();

        // delete the home page
        unset($pages[0]);

        // add the pages to the nav bar
        foreach ($pages as $page) {
            $this->navigation->addToMain($page);
        }

        if ($this->credentials->check()) {
            // add the admin links
            if ($this->credentials->hasAccess('admin')) {
                $this->navigation->addToMain(
                    ['title' => trans('navigation.logs'), 'slug' => 'logviewer', 'icon' => 'wrench'],
                    'admin'
                );
            }
        }
    }

    /**
     * Handle a navigation.main event second.
     *
     * @return void
     */
    public function onNavigationMainThird()
    {
        // get the pages
        $pages = $this->pagerepository->navigation();

        // select the home page
        $page = $pages[0];

        // add the page to the start of the main nav bars
        $this->navigation->addToMain($page, 'default', false);
        $this->navigation->addToMain($page, 'admin', false);

        // add the view users link
        if ($this->credentials->check() && $this->credentials->hasAccess('mod')) {
            $this->navigation->addToMain(
                ['title' => trans('navigation.users'), 'slug' => 'users', 'icon' => 'user'],
                'admin'
            );
        }
    }

    /**
     * Handle a navigation.bar event first.
     *
     * @return void
     */
    public function onNavigationBarFirst()
    {
        if ($this->credentials->check()) {
            // add the profile/history links
            $this->navigation->addToBar(
                ['title' => trans('navigation.profile'), 'slug' => 'account/profile', 'icon' => 'cog']
            );
            $this->navigation->addToBar(
                ['title' => trans('navigation.history'), 'slug' => 'account/history', 'icon' => 'history']
            );
        }
    }

    /**
     * Handle a navigation.bar event second.
     *
     * @return void
     */
    public function onNavigationBarSecond()
    {
        // add the admin links
        if ($this->credentials->check() && $this->credentials->hasAccess('admin')) {
            $this->navigation->addToBar(
                ['title' => trans('navigation.logs'), 'slug' => 'logviewer', 'icon' => 'wrench']
            );
        }
    }

    /**
     * Handle a navigation.bar event third.
     *
     * @return void
     */
    public function onNavigationBarThird()
    {
        if ($this->credentials->check()) {
            // add the view users link
            if ($this->credentials->hasAccess('mod')) {
                $this->navigation->addToBar(
                    ['title' => trans('navigation.users'), 'slug' => 'users', 'icon' => 'user']
                );
            }

            // add the create user link
            if ($this->credentials->hasAccess('admin')) {
                $this->navigation->addToBar(
                    ['title' => trans('navigation.new_user'), 'slug' => 'users/create', 'icon' => 'star']
                );
            }

            // add the create page link
            if ($this->credentials->hasAccess('edit')) {
                $this->navigation->addToBar(
                    ['title' => trans('navigation.new_page'), 'slug' => 'pages/create', 'icon' => 'pencil']
                );
            }

            // add the create post link
            if (Config::get('cms.blogging')) {
                if ($this->credentials->hasAccess('blog')) {
                    $this->navigation->addToBar(
                        ['title' => trans('navigation.new_post'), 'slug' => 'content/posts/create', 'icon' => 'book']
                    );
                }
            }

            // add the create event link
            if (Config::get('cms.events')) {
                if ($this->credentials->hasAccess('edit')) {
                    $this->navigation->addToBar(
                        ['title' => trans('navigation.new_event'), 'slug' => 'events/create', 'icon' => 'calendar']
                    );
                }
            }
        }
    }

    /**
     * Get the navigation instance.
     *
     * @return \GrahamCampbell\Navigation\Navigation
     */
    public function getNavigation()
    {
        return $this->navigation;
    }

    /**
     * Get the credentials instance.
     *
     * @return \GrahamCampbell\Credentials\Credentials
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Get the page repository instance.
     *
     * @return \App\Repositories\PageRepository
     */
    public function getPageRepository()
    {
        return $this->pagerepository;
    }
}
