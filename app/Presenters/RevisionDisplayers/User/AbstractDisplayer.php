<?php

/*
 * This file is part of Laravel Credentials.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Presenters\RevisionDisplayers\User;

use App\Presenters\RevisionDisplayers\AbstractRevisionDisplayer;
use App\Presenters\RevisionDisplayers\RevisionDisplayerInterface;

/**
 * This is the abstract displayer class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class AbstractDisplayer extends AbstractRevisionDisplayer implements RevisionDisplayerInterface
{
    /**
     * Get the change description.
     *
     * @return string
     */
    public function description()
    {
        if ($this->isCurrentUser()) {
            return $this->current();
        }

        return $this->external();
    }

    /**
     * Was the action by the actual user?
     *
     * @return bool
     */
    protected function wasActualUser()
    {
        return ($this->wrappedObject->user_id == $this->wrappedObject->revisionable_id || !$this->wrappedObject->user_id);
    }

    /**
     * Is the current user's account?
     *
     * @return bool
     */
    protected function isCurrentUser()
    {
        return ($this->credentials->check() && $this->credentials->getUser()->id == $this->wrappedObject->revisionable_id);
    }

    /**
     * Get the author details.
     *
     * @return string
     */
    protected function author()
    {
        if ($this->presenter->wasByCurrentUser() || !$this->wrappedObject->user_id) {
            return 'You ';
        }

        if (!$this->wrappedObject->security) {
            return 'This user ';
        }

        return $this->presenter->author().' ';
    }

    /**
     * Get the user details.
     *
     * @return string
     */
    protected function user()
    {
        if ($this->wrappedObject->security) {
            return ' this user\'s ';
        }

        $user = $this->wrappedObject->revisionable()->withTrashed()->first(['first_name', 'last_name']);

        return ' '.$user->first_name.' '.$user->last_name.'\'s ';
    }
}
