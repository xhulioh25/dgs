</div></div>

<div id="footer">
    <div class="container hidden-xs">
        <div class="row col-xs-12">
            <div class="col-xs-12">
                <div class="text-center">
                    <a href="#" style="margin-right: 20px">Shqip</a>
                    <a href="#">English (GB)</a>
                </div>
                <hr/>
                <p class="text-muted credit text-center">
                    <a href="http://www.cit.edu.al/">{{ Config::get('cms.author') }}</a> 2015. All rights reserved.
                </p>
            </div>
        </div>
    </div>
    <div class="container visible-xs">
        <p class="text-muted credit">
            <a href="http://www.cit.edu.al/">{{ Config::get('cms.author') }}</a> 2015. All rights reserved.
        </p>
    </div>
</div>

{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js') !!}
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery-timeago/1.4.1/jquery.timeago.min.js') !!}
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js') !!}
{!! Asset::scripts('main') !!}
@section('js')
@show
@if (Config::get('analytics.google'))
    @include('partials.analytics')
@endif
