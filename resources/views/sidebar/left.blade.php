<div id="sidebar-wrapper" class="well col-lg-2 col-sm-1 hidden-xs">
    <div class="column col-sm-12 col-xs-6 sidebar-offcanvas sidebar ">

            <ul class="nav">
                <li><a href="#" data-toggle="offcanvas" class=" visible-md visible-sm visible-xs text-center"><i class="glyphicon glyphicon-chevron-right"></i></a></li>
            </ul>

            <ul class="nav hidden-md hidden-sm" id="lg-menu">
                @include('partials.navigation-options')
                <li class="clearfix"><hr /></li>
                @include('partials.search-options')
            </ul>

            <!-- tiny only nav-->
            <ul class="nav visible-md visible-sm" id="xs-menu">
                <li><a href="#featured" class="text-center"><i class="glyphicon glyphicon-list-alt"></i></a></li>
                <li><a href="#stories" class="text-center"><i class="glyphicon glyphicon-list"></i></a></li>
                <li><a href="#" class="text-center"><i class="glyphicon glyphicon-paperclip"></i></a></li>
                <li><a href="#" class="text-center"><i class="glyphicon glyphicon-refresh"></i></a></li>
            </ul>

    </div>
</div>