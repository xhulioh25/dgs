<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Facades\PageRepository;

/*
|--------------------------------------------------------------------------
| Application Event Listeners
|--------------------------------------------------------------------------
|
| Here is where you can register all of the listeners for an application.
|
*/

if (Config::get('core.commands')) {
    $subscriber = App::make('App\Subscribers\CommandSubscriber');
    Event::subscribe($subscriber);
}

$subscriber = App::make('App\Subscribers\NavigationSubscriber');
Event::subscribe($subscriber);

$observer = App::make('App\Observers\PageObserver');
PageRepository::observe($observer);
