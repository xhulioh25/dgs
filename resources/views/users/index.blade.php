@extends(Config::get('core.default'))

@section('title')
<?php $__navtype = 'admin'; ?>
Users
@stop

@section('top')
<div class="page-header">
<h1>Users</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-8">
        <p class="lead">Here is a list of all the current users:</p>
    </div>
    @auth('admin')
        <div class="col-xs-4">
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! URL::route('users.create') !!}"><i class="fa fa-user"></i> New User</a>
            </div>
        </div>
    @endauth
</div>
<hr>
<div class="well">
    <table class="table">
        <thead>
            <th>{{trans('users.name')}}</th>
            <th>E-mail</th>
            <th>{{trans('users.options')}}</th>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{!! $user->name !!}</td>
                    <td>{!! $user->email !!}</td>
                    <td>
                        &nbsp;<a class="btn btn-success" href="{!! URL::route('users.show', array('users' => $user->id)) !!}"><i class="fa fa-file-text"></i> {{trans('buttons.show')}}</a>
                        @auth('admin')
                            &nbsp;<a class="btn btn-info" href="{!! URL::route('users.edit', array('users' => $user->id)) !!}"><i class="fa fa-pencil-square-o"></i> {{trans('buttons.edit')}}</a>
                        @endauth
                        &nbsp;<a class="btn btn-warning" href="#suspend_user_{!! $user->id !!}" data-toggle="modal" data-target="#suspend_user_{!! $user->id !!}"><i class="fa fa-ban"></i> {{trans('buttons.suspend')}}</a>
                        @auth('admin')
                            &nbsp;<a class="btn btn-default" href="#reset_user_{!! $user->id !!}" data-toggle="modal" data-target="#reset_user_{!! $user->id !!}"><i class="fa fa-lock"></i> {{trans('buttons.reset_pass')}}</a>
                            &nbsp;<a class="btn btn-danger" href="#delete_user_{!! $user->id !!}" data-toggle="modal" data-target="#delete_user_{!! $user->id !!}"><i class="fa fa-times"></i> {{trans('buttons.delete')}}</a>
                        @endauth
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{!! $links !!}
@stop

@section('bottom')
@include('users.suspends')
@auth('admin')
    @include('users.resets')
    @include('users.deletes')
@endauth
@stop
