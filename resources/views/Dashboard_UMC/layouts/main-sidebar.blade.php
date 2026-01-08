<!-- main-sidebar -->
		<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
		<aside class="app-sidebar sidebar-scroll">
			<div class="main-sidebar-header active">
				<a class="desktop-logo logo-light active mb-1" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo">
                    <b>{{__('Dashboard/main-sidebar_trans.index')}}</b>
                </a>
				<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
				<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
			</div>
            @if(\Auth::guard('web')->check())
                @include('Dashboard_UMC.layouts.main-sidebar.users-main-sidebar')
            @endif

            @if(\Auth::guard('clients')->check())
                @include('Dashboard_UMC.layouts.main-sidebar.clients-main-sidebar')
            @endif

            @if(\Auth::guard('merchants')->check())
                @include('Dashboard_UMC.layouts.main-sidebar.merchants-main-sidebar')
            @endif
		</aside>
<!-- main-sidebar -->
