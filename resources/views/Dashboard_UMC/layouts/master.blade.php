<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		@include('Dashboard_UMC.layouts.head')

        @vite(['resources/css/app.css', 'resources/js/app.js'])

	</head>

	<body class="main-body app sidebar-mini">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.15.3/echo.js"></script>
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('Dashboard_UMC/layouts.main-sidebar')
		<!-- main-content -->
		<div class="main-content app-content">
            @if(\Auth::guard('web')->check())
                @include('Dashboard_UMC.layouts.main-header.users-main-header')
            @endif

            @if(\Auth::guard('merchants')->check())
                @include('Dashboard_UMC.layouts.main-header.merchants-main-header')
            @endif

            @if(\Auth::guard('clients')->check())
                @include('Dashboard_UMC.layouts.main-header.clients-main-header')
            @endif

                <!-- container -->
                <div class="container-fluid">
                    @yield('page-header')
                    @yield('content')
                    @include('Dashboard_UMC/layouts.sidebar')
                    @include('Dashboard_UMC/layouts.models')
                    @include('Dashboard_UMC/layouts.footer')
                    @include('Dashboard_UMC/layouts.footer-scripts')
                </div>
                <!-- Container closed -->
        </div>
        <!-- main-content closed -->
	</body>
</html>
