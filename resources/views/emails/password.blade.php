@extends(Config::get('core.email'))

@section('content')
<p>Here is your temporary password:</p>
<blockquote>{!! $password !!}</blockquote>
<p>You should change it to something more memorable on the account page after you login.</p>
@stop
