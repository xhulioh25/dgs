@extends(Config::get('core.default'))

@section('title')
    @if (Lang::has('navigation.'.$page->nav_title))
        {{trans('buttons.edit')}} {{ trans('navigation.'.$page->nav_title) }}
    @else
        {{trans('buttons.edit')}} {{$page->title}}
    @endif
@stop

@section('top')
<div class="page-header">
<h1>
    @if (Lang::has('navigation.'.$page->nav_title))
        {{trans('buttons.edit')}} {{ trans('navigation.'.$page->nav_title) }}
    @else
        {{trans('buttons.edit')}} {{$page->title}}
    @endif
</h1>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-xs-6">
        <p class="lead">
            {{trans('pages.edit_message')}}:
        </p>
    </div>
    <div class="col-xs-6">
        <div class="pull-right">
            <a class="btn btn-success" href="{!! URL::route('pages.show', array('pages' => $page->slug)) !!}"><i class="fa fa-file-text"></i> {{trans('buttons.show')}}</a> <a class="btn btn-danger" href="#delete_page" data-toggle="modal" data-target="#delete_page"><i class="fa fa-times"></i> {{trans('buttons.delete')}}</a>
        </div>
    </div>
</div>
<hr>
<div class="well">
    <?php
    $form = ['url' => URL::route('pages.update', ['pages' => $page->slug]),
        'method' => 'PATCH',
        'button' => 'save',
        'defaults' => [
            'title' => $page->title,
            'nav_title' => $page->nav_title,
            'slug' => $page->slug,
            'icon' => $page->icon,
            'body' => $page->body,
            'css' => $page->css,
            'js' => $page->js,
            'show_title' => ($page->show_title == true),
            'show_nav' => ($page->show_nav == true),
    ], ];
    ?>
    @include('pages.form')
</div>
@stop

@section('bottom')
@auth('edit')
    @include('pages.delete')
@endauth
@stop

@section('css')
{!! HTML::style('//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/css/bootstrap3/bootstrap-switch.min.css') !!}
@stop

@section('js')
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.2/js/bootstrap-switch.min.js') !!}
<script type="text/javascript">
$(document).ready(function () {
    $(".make-switch").bootstrapSwitch();
});
</script>
@stop
