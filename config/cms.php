<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Site Description
    |--------------------------------------------------------------------------
    |
    | This defines the site description.
    |
    */

    'description' => 'Wiki Services is a platform developed by cit students.',

    /*
    |--------------------------------------------------------------------------
    | Site Author
    |--------------------------------------------------------------------------
    |
    | This defines the site author.
    |
    */

    'author' => 'CIT Students',

    /*
    |--------------------------------------------------------------------------
    | Navigation Text
    |--------------------------------------------------------------------------
    |
    | This defines property from the user model to use on the navigation bar.
    |
    | This could be: 'email', 'name', 'first_name', 'last_name'
    |
    */

    'nav' => 'name',

    /*
    |--------------------------------------------------------------------------
    | Enable Eval On Pages
    |--------------------------------------------------------------------------
    |
    | This defines if the page eval functionality is enabled.
    |
    | Disabling it will prevent people from executing php on pages. This would
    | be useful if you wanted to prevent users writing dynamic pages, because
    | allowing them to execute php means they can do anything really.
    |
    | Default to true.
    |
    */

    'eval' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable Blogging
    |--------------------------------------------------------------------------
    |
    | This defines if the blog functionality is enabled.
    |
    | Disabling it will not delete anything from your database, it will just
    | inaccessible from the web. All associated routes will not be registered,
    | and the navigation bar will not show any associated links.
    |
    | Default to true.
    |
    */

    'blogging' => true,

    /*
    |--------------------------------------------------------------------------
    | Comment Fetch Interval
    |--------------------------------------------------------------------------
    |
    | This defines the minimum time interval for a client's browser to check
    | for new comments on a blog post in milliseconds.
    |
    | Default to 5000.
    |
    */

    'commentfetch' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Comment Transition Time
    |--------------------------------------------------------------------------
    |
    | This defines how long comment transitions take to complete in
    | milliseconds. It must be a number divisible by 2.
    |
    | Default to 300.
    |
    */

    'commenttrans' => 300,

    /*
    |--------------------------------------------------------------------------
    | Enable Events
    |--------------------------------------------------------------------------
    |
    | This defines if the event functionality is enabled.
    |
    | Disabling it will not delete anything from your database, it will just
    | inaccessible from the web. All associated routes will not be registered,
    | and the navigation bar will not show any associated links.
    |
    | Default to true.
    |
    */

    'events' => false,

    /*
    |--------------------------------------------------------------------------
    | Comment Model
    |--------------------------------------------------------------------------
    |
    | This defines the comment model to be used.
    |
    | Default: 'App\Models\Comment'
    |
    */

    'comment' => 'App\Models\Comment',

    /*
    |--------------------------------------------------------------------------
    | Event Model
    |--------------------------------------------------------------------------
    |
    | This defines the event model to be used.
    |
    */

    'event' => 'App\Models\Event',

    /*
    |--------------------------------------------------------------------------
    | Page Model
    |--------------------------------------------------------------------------
    |
    | This defines the page model to be used.
    |
    | Default: 'App\Models\Page'
    |
    */

    'page' => 'App\Models\Page',

    /*
    |--------------------------------------------------------------------------
    | Post Model
    |--------------------------------------------------------------------------
    |
    | This defines the post model to be used.
    |
    | Default: 'App\Models\Post'
    |
    */

    'post' => 'App\Models\Post',

];
