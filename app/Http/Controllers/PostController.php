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

use GrahamCampbell\Binput\Facades\Binput;
use App\Facades\PostRepository;
use App\Facades\Credentials;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * This is the post controller class.
 *
 * @author Graham Campbell <graham@alt-three.com>
 */
class PostController extends AbstractController
{
    /**
     * Create a new instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->setPermissions([
            'create'  => 'content',
            'store'   => 'content',
            'edit'    => 'content',
            'update'  => 'content',
            'destroy' => 'content',
        ]);

        parent::__construct();
    }

    /**
     * Display a listing of the posts.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = PostRepository::paginate();
        $links = PostRepository::links();

        return View::make('posts.index', ['posts' => $posts, 'links' => $links]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('posts.create');
    }

    /**
     * Store a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = array_merge(['user_id' => Credentials::getuser()->id], Binput::only([
            'title', 'summary', 'body',
        ]));

        $val = PostRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return Redirect::route('content.posts.create')->withInput()->withErrors($val->errors());
        }

        $post = PostRepository::create($input);

        return Redirect::route('content.posts.show', ['posts' => $post->id])
            ->with('success', 'Your post has been created successfully.');
    }

    /**
     * Show the specified post.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $post = PostRepository::find($id);
        $this->checkPost($post);

        $comments = $post->comments()->orderBy('id', 'desc')->get();

        return View::make('posts.show', ['post' => $post, 'comments' => $comments]);
    }

    /**
     * Show the form for editing the specified post.
     *
     * @param int $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = PostRepository::find($id);
        $this->checkPost($post);

        return View::make('posts.edit', ['post' => $post]);
    }

    /**
     * Update an existing post.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $input = Binput::only(['title', 'summary', 'body']);

        $val = PostRepository::validate($input, array_keys($input));
        if ($val->fails()) {
            return Redirect::route('content.posts.edit', ['posts' => $id])->withInput()->withErrors($val->errors());
        }

        $post = PostRepository::find($id);
        $this->checkPost($post);

        $post->update($input);

        return Redirect::route('content.posts.show', ['posts' => $post->id])
            ->with('success', 'Your post has been updated successfully.');
    }

    /**
     * Delete an existing post.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = PostRepository::find($id);
        $this->checkPost($post);

        $post->delete();

        return Redirect::action('PostController@index')
            ->with('success', 'Your post has been deleted successfully.');
    }

    /**
     * Check the post model.
     *
     * @param mixed $post
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     *
     * @return void
     */
    protected function checkPost($post)
    {
        if (!$post) {
            throw new NotFoundHttpException('Post Not Found');
        }
    }
}
