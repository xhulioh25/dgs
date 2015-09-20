<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Navigation;

use App\Credentials;
/**
 * This is the navigation factory class.
 *
 */
class Factory
{
    /**
     * The credentials instance.
     *
     */
    protected $credentials;

    /**
     * The navigation instance.
     *
     */
    protected $navigation;

    /**
     * The platform name.
     *
     * @var string
     */
    protected $name;

    /**
     * The user property.
     *
     * @var string
     */
    protected $property;

    /**
     * The inverse navigation.
     *
     * @var bool
     */
    protected $inverse;

    /**
     * Create a new instance.
     *
     * @param string                                  $name
     * @param string                                  $property
     * @param bool                                    $inverse
     *
     * @return void
     */
    public function __construct(Credentials $credentials, Navigation $navigation, $name, $property, $inverse)
    {
        $this->credentials = $credentials;
        $this->navigation = $navigation;
        $this->name = $name;
        $this->property = $property;
        $this->inverse = $inverse;
    }

    /**
     * Create a navigation bar.
     *
     * @param string $type
     *
     * @return string
     */
    public function make($type = 'default')
    {
        if ($this->credentials->check()) {
            if ($type === 'admin') {
                if ($this->credentials->hasAccess('admin')) {
                    // the requested type is admin, and the user is an admin
                    return $this->navigation->render('admin', 'admin', [
                        'title'   => 'Admin Panel',
                        'side'    => $this->getSide(),
                        'inverse' => $this->inverse,
                    ]);
                } else {
                    // the requested type is admin, and the user is NOT an admin
                    return $this->navigation->render('default', 'default', [
                        'title'   => $this->name,
                        'side'    => $this->getSide(),
                        'inverse' => $this->inverse,
                    ]);
                }
            } else {
                // the requested type is default, and the user is logged in
                return $this->navigation->render('default', 'default', [
                    'title'   => $this->name,
                    'side'    => $this->getSide(),
                    'inverse' => $this->inverse,
                ]);
            }
        } else {
            // the requested type is default, and the user is NOT logged in
            return $this->navigation->render('default', false, [
                'title'   => $this->name,
                'inverse' => $this->inverse,
            ]);
        }
    }

    /**
     * Get the relevant user property for the side bar.
     *
     * @return string
     */
    protected function getSide()
    {
        $propery = $this->property;
        $user = $this->credentials->getDecoratedUser();

        return $user->$propery;
    }

    /**
     * Return the credentials instance.
     *
     */
    public function getCredentials()
    {
        return $this->credentials;
    }

    /**
     * Return the navigation instance.
     *
     */
    public function getNavigation()
    {
        return $this->navigation;
    }
}
