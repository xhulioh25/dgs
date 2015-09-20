@extends(Config::get('core.default'))

@section('title')
History
@stop

@section('top')
<div class="page-header">
<h1>History</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-12">
        <p class="lead">
            Here is your most recent history:
        </p>
    </div>
</div>
<hr>
@include('users.history')
@stop

@section('bottom')
@include('account.delete')
@stop
