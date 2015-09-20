<?php

/*
 * This file is part of Laravel Credentials.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Repositories;

/**
 * This is the slug repository trait.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
trait SlugRepositoryTrait
{
    /**
     * Find an existing model by slug.
     *
     * @param string   $slug
     * @param string[] $columns
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($slug, array $columns = ['*'])
    {
        $model = $this->model;

        return $model::where('slug', '=', $slug)->first($columns);
    }
}
