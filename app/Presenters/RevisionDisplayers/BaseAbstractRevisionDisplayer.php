<?php

/*
 * This file is part of Laravel Credentials.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Presenters\RevisionDisplayers;

use App\Presenters\RevisionPresenter;

/**
 * This is the abstract revision displayer class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
abstract class BaseAbstractRevisionDisplayer
{
    /**
     * The presenter instance.
     *
     * @var \GrahamCampbell\Credentials\Presenters\RevisionPresenter
     */
    protected $presenter;

    /**
     * The credentials instance.
     *
     * @var \GrahamCampbell\Credentials\Credentials
     */
    protected $credentials;

    /**
     * The resource instance.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $resource;

    /**
     * Create a new instance.
     *
     * @param \GrahamCampbell\Credentials\Presenters\RevisionPresenter $presenter
     *
     * @return void
     */
    public function __construct(RevisionPresenter $presenter)
    {
        $this->presenter = $presenter;
        $this->credentials = $this->presenter->getCredentials();
        $this->wrappedObject = $this->presenter->getWrappedObject();
    }

    /**
     * Get the change details.
     *
     * @return string
     */
    protected function details()
    {
        return ' from "'.$this->wrappedObject->old_value.'" to "'.$this->wrappedObject->new_value.'".';
    }
}
