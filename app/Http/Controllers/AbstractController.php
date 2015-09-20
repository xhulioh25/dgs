<?php

/*
 * This file is part of Bootstrap CMS.
 *
 * (c) Graham Campbell <graham@alt-three.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use App\Http\Middleware\Auth\Blog;
use App\Http\Middleware\Auth\Edit;
use App\Models\User;
use App\Http\Middleware\Auth\Admin;
use App\Http\Middleware\Auth\Mod;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * This is the abstract controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
abstract class AbstractController extends Controller
{
    use DispatchesCommands, ValidatesRequests;

    /**
     * A list of methods protected by edit permissions.
     *
     * @var string[]
     */
    protected $edits = [];

    /**
     * A list of methods protected by blog permissions.
     *
     * @var string[]
     */
    protected $blogs = [];

    /**
     * A list of methods protected by user permissions.
     *
     * @var string[]
     */
    protected $users = [];

    /**
     * A list of methods protected by mod permissions.
     *
     * @var string[]
     */
    protected $mods = [];

    /**
     * A list of methods protected by admin permissions.
     *
     * @var string[]
     */
    protected $admins = [];

    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {

        if ($this->edits) {
            $this->middleware(Edit::class, ['only' => $this->edits]);
        }

        if ($this->blogs) {
            $this->middleware(Blog::class, ['only' => $this->blogs]);
        }

        if ($this->users) {
            $this->middleware(User::class, ['only' => $this->users]);
        }

        if ($this->mods) {
            $this->middleware(Mod::class, ['only' => $this->mods]);
        }

        if ($this->admins) {
            $this->middleware(Admin::class, ['only' => $this->admins]);
        }
    }

    protected function setPermission($action, $permission)
    {
        $this->{$permission.'s'}[] = $action;
    }

    /**
     * Set the permissions.
     *
     * @param string[] $permissions
     *
     * @return void
     */
    protected function setPermissions($permissions)
    {
        foreach ($permissions as $action => $permission) {
            $this->setPermission($action, $permission);
        }
    }
}
