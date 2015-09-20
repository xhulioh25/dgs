<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

//Route::group(['suffix' => '{lang?}'], function() {
// send users to the home page
    $router->get('/', ['as' => 'base', function () {
        Session::flash('', ''); // work around laravel bug if there is no session yet
        Session::reflash();

        return Redirect::to(Config::get('core.home', 'content/posts'));
    }]);

// send users to the posts page
    if (Config::get('cms.blogging')) {
        $router->get('content', ['as' => 'content', function () {
            Session::flash('', ''); // work around laravel bug if there is no session yet
            Session::reflash();

            return Redirect::route('content.posts');
        }]);
    }

// page routes
    $router->resource('pages', 'PageController');

// blog routes
    if (Config::get('cms.blogging')) {
        $router->resource('content/posts', 'PostController');
        $router->resource('content/posts.comments', 'CommentController');
    }

// event routes
    if (Config::get('cms.events')) {
        $router->resource('events', 'EventController');
    }

    $router->get('account', ['as' => 'account', function () {
        Session::flash('', ''); // work around laravel bug if there is no session yet
        Session::reflash();

        return Redirect::route('account.profile');
    }]);

// account routes
    $router->get('account/history', ['as' => 'account.history', 'uses' => 'AccountController@History']);
    $router->get('account/profile', ['as' => 'account.profile', 'uses' => 'AccountController@Profile']);
    $router->delete('account/profile', ['as' => 'account.profile.delete', 'uses' => 'AccountController@deleteProfile']);
    $router->patch('account/details', ['as' => 'account.details.patch', 'uses' => 'AccountController@patchDetails']);
    $router->patch('account/password', ['as' => 'account.password.patch', 'uses' => 'AccountController@patchPassword']);

// registration routes
    if (Config::get('credentials.regallowed')) {
        $router->get('account/register', ['as' => 'account.register', 'uses' => 'RegistrationController@getRegister']);
        $router->post('account/register', ['as' => 'account.register.post', 'uses' => 'RegistrationController@postRegister']);
    }

// activation routes
    if (Config::get('credentials.activation')) {
        $router->get('account/activate/{id}/{code}', ['as' => 'account.activate', 'uses' => 'ActivationController@getActivate']);
        $router->get('account/resend', ['as' => 'account.resend', 'uses' => 'ActivationController@getResend']);
        $router->post('account/resend', ['as' => 'account.resend.post', 'uses' => 'ActivationController@postResend']);
    }

// reset routes
    $router->get('account/reset', ['as' => 'account.reset', 'uses' => 'ResetController@getReset']);
    $router->post('account/reset', ['as' => 'account.reset.post', 'uses' => 'ResetController@postReset']);
    $router->get('account/password/{id}/{code}', ['as' => 'account.password', 'uses' => 'ResetController@getPassword']);

// login routes
    $router->get('account/login', ['as' => 'account.login', 'uses' => 'LoginController@getLogin']);
    $router->post('account/login', ['as' => 'account.login.post', 'uses' => 'LoginController@postLogin']);
    $router->get('account/logout', ['as' => 'account.logout', 'uses' => 'LoginController@Logout']);

// user routes
    $router->resource('users', 'UserController');
    $router->post('users/{users}/suspend', ['as' => 'users.suspend', 'uses' => 'UserController@suspend']);
    $router->post('users/{users}/reset', ['as' => 'users.reset', 'uses' => 'UserController@reset']);
    if (Config::get('credentials.activation')) {
        $router->post('users/{users}/resend', ['as' => 'users.resend', 'uses' => 'UserController@resend']);
    }

//logviewer routes
    $router->get('logviewer', ['as' => 'logviewer', 'uses' => 'LogViewerController@getIndex']);
    $router->get('logviewer/{date}/delete', ['as' => 'logviewer.delete', 'uses' => 'LogViewerController@getDelete']);
    $router->get('logviewer/{date}/{level?}', ['as' => 'logviewer.show', 'uses' => 'LogViewerController@getShow']);
    $router->get('logviewer/data/{date}/{level?}', ['as' => 'logviewer.data', 'uses' => 'LogViewerController@getData']);
//});