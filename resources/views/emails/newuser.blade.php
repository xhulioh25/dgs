@extends(Config::get('core.email'))

@section('content')
<p>An admin from <a href="{!! $url !!}">{!! Config::get('core.name') !!}</a> has created you an account.</p>
<p>Here is your temporary password:</p>
<blockquote>{!! $password !!}</blockquote>
<p>You should change it to something more memorable on the account page after you login.</p>
@stop
