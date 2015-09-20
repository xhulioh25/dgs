@extends(Config::get('core.default'))

@section('title')
Profile
@stop

@section('top')
<div class="page-header">
<h1>Profile</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-8">
        <p class="lead">
            Here is your profile:
        </p>
    </div>
    <div class="col-xs-4">
        <div class="pull-right">
            <a class="btn btn-danger" href="#delete_account" data-toggle="modal" data-target="#delete_account"><i class="fa fa-times"></i> Delete Account</a>
        </div>
    </div>
</div>
<hr>
<h3>Change Details</h3>
<div class="well">
    <?php
    $form = ['url' => URL::route('account.details.patch'),
        'method' => 'PATCH',
        'button' => 'Save Details',
        'defaults' => [
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
    ], ];
    ?>
    @include('account.details')
</div>
<hr>
<h3>Change Password</h3>
<div class="well">
    <?php
    $form = ['url' => URL::route('account.password.patch'),
        'method' => 'PATCH',
        'button' => 'Save Password',
    ];
    ?>
    @include('account.password')
</div>
@stop

@section('bottom')
@include('account.delete')
@stop
