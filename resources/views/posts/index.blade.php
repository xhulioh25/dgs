@extends(Config::get('core.default'))

@section('title')
{{trans('navigation.posts')}}
@stop

@section('top')
@stop

@section('content')
<div class="row">

    @auth('blog')
        <div class="col-xs-12">
            <div class="pull-right">
                <a class="btn btn-primary" href="{!! URL::route('content.posts.create') !!}"><i class="fa fa-book"></i> New Post</a>
            </div>
        </div>
    @endauth
</div>
@if (count($posts) == 0)
    <div class="clearfix"><hr/></div>
    <div class="col-xs-12">
        <p class="lead">
            {{trans('general.no_posts')}}
        </p>
    </div>

@else
@foreach($posts as $post)
    <h2><a href="{!! URL::route('content.posts.show', array('posts' => $post->id)) !!}">{!! $post->title !!}</a></h2>
    <p>
        <strong>{!! $post->summary !!}</strong>
    </p>
    <p>
        @auth('blog')
             <a class="btn btn-info" href="{!! URL::route('content.posts.edit', array('posts' => $post->id)) !!}"><i class="fa fa-pencil-square-o"></i> Edit Post</a> <a class="btn btn-danger" href="#delete_post_{!! $post->id !!}" data-toggle="modal" data-target="#delete_post_{!! $post->id !!}"><i class="fa fa-times"></i> Delete Post</a>
        @endauth
    </p>
    <br>
@endforeach
{!! $links !!}
@endif
@stop

@section('bottom')
@auth('blog')
    @include('posts.deletes')
@endauth
@stop
