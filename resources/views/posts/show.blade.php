@extends(Config::get('core.default'))

@section('title')
{{ $post->title }}
@stop

@section('top')
<div class="page-header">
<h1>{{ $post->title }}</h1>
</div>
@stop

@section('content')
@auth('blog')
    <div class="well clearfix">
        <div class="hidden-xs">
            <div class="col-xs-6">
                <p>
                    <strong>Post Owner:</strong> {!! $post->owner !!}
                </p>
                <a class="btn btn-info" href="{!! URL::route('content.posts.edit', array('posts' => $post->id)) !!}"><i class="fa fa-pencil-square-o"></i>{!!trans('buttons.edit')!!}</a> <a class="btn btn-danger" href="#delete_post" data-toggle="modal" data-target="#delete_post"><i class="fa fa-times"></i>{!!trans('buttons.delete')!!}</a>
            </div>
            <div class="col-xs-6">
                <div class="pull-right">
                    <p>
                        <em>{!!trans('general.created')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$post->created_at)->diffForHumans() !!}</em>
                    </p>
                    <p>
                        <em>{!!trans('general.updated')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$post->updated_at)->diffForHumans() !!}</em>
                    </p>
                </div>
            </div>
        </div>
        <div class="visible-xs">
            <div class="col-xs-12">
                <p>
                    <strong>{!!trans('general.owner')!!}:</strong> {!! $post->owner !!}
                </p>
                <p>
                    <em>{!!trans('general.created')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$post->created_at)->diffForHumans() !!}</em>
                </p>
                <p>
                    <em>{!!trans('general.updated')!!}: {!! \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$post->updated_at)->diffForHumans() !!}</em>
                </p>
                <a class="btn btn-info" href="{!! URL::route('content.posts.edit', array('posts' => $post->id)) !!}"><i class="fa fa-pencil-square-o"></i>{{trans('buttons.edit')}}</a> <a class="btn btn-danger" href="#delete_post" data-toggle="modal" data-target="#delete_post"><i class="fa fa-times"></i>{{trans('buttons.delete')}}</a>
            </div>
        </div>
    </div>
    <hr>
@endauth

<div class="row">
    <div class="hidden-xs">
        <div class="col-md-8 col-xs-6">
            <p class="lead">{!! $post->summary !!}</p>
        </div>
        <div class="col-md-4 col-xs-6">
            <div class="pull-right">
                <p>Author: {!! $post->author !!}</p>
            </div>
        </div>
    </div>
    <div class="visible-xs">
        <div class="col-xs-12">
            <p class="lead">{!! $post->summary !!}</p>
            <p>Author: {!! $post->author !!}</p>
        </div>
    </div>
</div>
<br>

{!! $post->content !!}
<br><hr>

<h3>Comments</h3>
@auth('user')
    <br>
    <div class="well well-sm clearfix">
        {!! Form::open(array('id' => 'commentform', 'url' => URL::route('content.posts.comments.store', array('posts' => $post->id)), 'method' => 'POST', 'class' => 'form-vertical')) !!}
            <div class="form-group">
                <div class="col-xs-12">
                    <textarea id="body" name="body" class="form-control comment-box" placeholder="{{trans('general.comment')}}..." rows="3"></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12 comment-button">
                    <button id="contact-submit" type="submit" class="btn btn-primary"><i class="fa fa-comment"></i> {{trans('buttons.comment')}}</button> <label id="commentstatus"></label>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@else
<p>
    @if (Config::get('credentials.regallowed'))
        <strong>Please <a href="{!! URL::route('account.login') !!}">login</a> or <a href="{!! URL::route('account.register') !!}">register</a> to post a comment.</strong>
    @else
        <strong>Please <a href="{!! URL::route('account.login') !!}">login</a> to post a comment.</strong>
    @endif
</p>
@endauth
<br>

<?php $post_id = $post->id; ?>
<div id="comments" data-url="{!! URL::route('content.posts.comments.index', array('posts' => $post_id)) !!}">
    @if (count($comments) == 0)
    <p id="nocomments">There are currently no comments.</p>
    @else
        @foreach ($comments as $comment)
            @include('posts.comment')
        @endforeach
    @endif
</div>
@stop

@section('bottom')
@auth('blog')
@include('posts.delete')
@endauth
@auth('mod')
<div id="edit_comment" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Comment</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    {!! Form::open(array('id' => 'edit_commentform', 'method' => 'PATCH', 'class' => 'form-vertical', 'data-pk' => '0')) !!}
                        <input id="verion" name="version" value="1" type="hidden">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <textarea id="edit_body" name="edit_body" class="form-control comment-box" placeholder="Type a comment..." rows="3"></textarea>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            <div class="modal-footer">
                <button id="edit_comment_cancel" type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button id="edit_comment_ok" type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>
@endauth
@stop

@section('js')
{!! HTML::script('//cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js') !!}
<script>
var cmsCommentInterval = {!! Config::get('cms.commentfetch') !!};
var cmsCommentTime = {!! Config::get('cms.commenttrans') !!};
</script>
{!! Asset::scripts('comment') !!}
@stop
