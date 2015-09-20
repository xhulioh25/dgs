@extends(Config::get('core.default'))

@section('title')
<?php $__navtype = 'admin'; ?>
{{trans('buttons.edit')}} {{ $user->name }}
@stop

@section('top')
<div class="page-header">
<h1>{{trans('buttons.edit')}} {{ $user->name }}</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-6">
        <p class="lead">
            @if($user->id == Credentials::getUser()->id)
                Currently editing your profile:
            @else
                Currently editing {!! $user->name !!}'s profile:
            @endif
        </p>
    </div>
    <div class="col-xs-6">
        <div class="pull-right">
            &nbsp;<a class="btn btn-success" href="{!! URL::route('users.show', array('users' => $user->id)) !!}"><i class="fa fa-file-text"></i> {{trans('buttons.show')}}</a>
            &nbsp;<a class="btn btn-warning" href="#suspend_user" data-toggle="modal" data-target="#suspend_user"><i class="fa fa-ban"></i> {{trans('buttons.suspend')}}</a>
            @auth('admin')
                &nbsp;<a class="btn btn-default" href="#reset_user" data-toggle="modal" data-target="#reset_user"><i class="fa fa-lock"></i> {{trans('buttons.reset')}}</a>
                &nbsp;<a class="btn btn-danger" href="#delete_user" data-toggle="modal" data-target="#delete_user"><i class="fa fa-times"></i> {{trans('buttons.delete')}}</a>
            @endauth
        </div>
    </div>
</div>
<hr>
<div class="well">
    <?php
    $form = ['url' => URL::route('users.update', ['users' => $user->id]),
        'method' => 'PATCH',
        'button' => 'Save User',
        'defaults' => [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
    ], ];
    foreach ($groups as $group) {
        $form['defaults']['group_'.$group->id] = ($user->inGroup($group));
    }
    ?>
    @include('users.form')
</div>
@stop

@section('bottom')
@include('users.suspend')
@auth('admin')
    @include('users.reset')
    @include('users.delete')
@endauth
@stop

@section('css')
{!! HTML::style('//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.1.0/css/bootstrap3/bootstrap-switch.min.css') !!}
@stop

@section('js')
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.1.0/js/bootstrap-switch.min.js') !!}
<script type="text/javascript">
$(document).ready(function () {
    $(".make-switch").bootstrapSwitch();
});
</script>
@stop
