<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>{{ Config::get('core.name') }} - @section('title')
        @show</title>
    @include('partials.header')
</head>
<body>
<div id="wrap" >
    @navigation
    <div class="row row-offcanvas row-offcanvas-left">
        @include('sidebar.left')
    </div>
    <div class="row row-offcanvas row-offcanvas-left">
        @include('sidebar.right')
    </div>
        {{--<div class="">--}}
            <div class="container col-lg-8 col-sm-10 col-lg-offset-2 col-sm-offset-1">
                @section('top')
                @show
                @include('partials.notifications')
                @section('content')
                @show
            {{--</div>--}}
            @include('partials.footer')
            @section('bottom')
            @show
    </div>

</div>
</body>
<div id="adv_search" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                <h4 class="modal-title">{{trans('options.search')}}</h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal"role="form">
                    <div class="form-group">
                        <label for="filter">{{trans('options.filter')}}</label>
                        <select class="form-control">
                            <option value="1">{{trans('options.form_code')}}</option>
                            <option value="2">{{trans('options.by_ministry')}}</option>
                            <option value="3">{{trans('options.by_institution')}}</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label for="contain" class="col-lg-4"></label>
                        <input class="form-control col-lg-12" type="text" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>
</html>
