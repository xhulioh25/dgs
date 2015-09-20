@extends(Config::get('core.default'))

@section('title')
    @if (Lang::has('navigation.'.$page->nav_title))
        {{trans('buttons.edit')}} {{ trans('navigation.'.$page->nav_title) }}
    @else
        {{trans('buttons.edit')}} {{$page->title}}
    @endif
@stop

@section('top')
@if($page->show_title)
    <div class="page-header">
        <h1>
            @if (Lang::has('navigation.'.$page->nav_title))
                {{ trans('navigation.'.$page->nav_title) }}
            @else
                {{$page->title}}
            @endif
        </h1>
    </div>
@endif
@stop

@section('content')
@auth('edit')
    <div class="well clearfix">
        <div class="hidden-xs">
            <div class="col-xs-6">
                <p>
                    <strong>{!!trans('general.owner')!!}:</strong> {!! $page->owner !!}
                </p>
                <a class="btn btn-info" href="{!! URL::route('pages.edit', array('pages' => $page->slug)) !!}"><i class="fa fa-pencil-square-o"></i>{!!trans('buttons.edit')!!}</a><a style="margin-left: 2px" class="btn btn-danger" href="#delete_page" data-toggle="modal" data-target="#delete_page"><i class="fa fa-times"></i>{!!trans('buttons.delete')!!}</a>
            </div>
            <div class="col-xs-6">
                <div class="pull-right">
                    <p>
                        <em>{!!trans('general.created')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$page->created_at)->diffForHumans() !!}</em>
                    </p>
                    <p>
                        <em>{!!trans('general.updated')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$page->updated_at)->diffForHumans() !!}</em>
                    </p>
                </div>
            </div>
        </div>
        <div class="visible-xs">
            <div class="col-xs-12">
                <p>
                    <strong>{!!trans('general.owner')!!}:</strong> {!! $page->owner !!}
                </p>
                <p>
                    <em>{!!trans('general.created')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$page->created_at)->diffForHumans() !!}</em>
                </p>
                <p>
                    <em>{!!trans('general.updated')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$page->updated_at)->diffForHumans() !!}</em>
                </p>
                <a class="btn btn-info" href="{!! URL::route('pages.edit', array('pages' => $page->slug)) !!}"><i class="fa fa-pencil-square-o"></i>{!!trans('buttons.edit')!!}</a> <a class="btn btn-danger" href="#delete_page" data-toggle="modal" data-target="#delete_page"><i class="fa fa-times"></i>{!!trans('buttons.delete')!!}</a>
            </div>
        </div>
    </div>
    <hr>
@endauth
@if (Config::get('cms.eval', false))
<?php eval('?>'.$page->body); ?>
@else
{!! $page->body !!}
@endif
@stop

@section('bottom')
@auth('edit')
    @include('pages.delete')
@endauth
@stop

@section('css')
{!! $page->css !!}
@stop

@section('js')
{!! $page->js !!}
@stop
