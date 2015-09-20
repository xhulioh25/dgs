<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Presenters;

use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * This is the event presenter class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class EventPresenter extends BasePresenter
{
    use OwnerPresenterTrait, ContentPresenterTrait;
}
