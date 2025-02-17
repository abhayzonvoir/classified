


<div class="navbar-custom-menu pull-left">
    <ul class="nav navbar-nav">
        <!-- =================================================== -->
        <!-- ========== Top menu items (ordered left) ========== -->
        <!-- =================================================== -->
    
        @if (auth()->check())
            <li><a href="{{ admin_url('dashboard') }}"><i class="fa fa-dashboard"></i> <span>{{ trans('admin::messages.dashboard') }}</span></a></li>
        @endif

        <!-- ========== End of top menu left items ========== -->
    </ul>
</div>


<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- ========================================================= -->
        <!-- ========== Top menu right items (ordered left) ========== -->
        <!-- ========================================================= -->
        
        <li><a href="{{ url('/') }}" target="_blank"><i class="fa fa-home"></i> <span>{{ trans('admin::messages.Home') }}</span></a></li>
        
        @if (auth()->guest())
            <li><a href="{{ admin_url('login') }}">{{ trans('admin::messages.login') }}</a></li>
        @else
            <li><a href="{{ admin_url('logout') }}"><i class="fa fa-btn fa-sign-out"></i> {{ trans('admin::messages.logout') }}</a></li>
        @endif
        
        <!-- ========== End of top menu right items ========== -->
    </ul>
</div>
