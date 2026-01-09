@extends('Dashboard_UMC/layouts.master2')
@section('title')
{{__('Dashboard/login_trans.SignIn')}}
@endsection
@section('css')

    <style>
        .panel {display: none;}
    </style>


    <!-- Sidemenu-respoansive-tabs css -->
    <link href="{{URL::asset('assets/plugins/sidemenu-responsive-tabs/css/sidemenu-responsive-tabs.css')}}" rel="stylesheet">
@endsection
@section('content')
		<div class="container-fluid">
			<div class="row no-gutter">
				<!-- The image half -->
				<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
					<div class="row wd-100p mx-auto text-center">
						<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
							<img src="{{URL::asset('assets/img/media/login.png')}}" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
						</div>
					</div>
				</div>
				<!-- The content half -->
				<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
					<div class="login d-flex align-items-center py-2">
						<!-- Demo content-->
						<div class="container p-0">
							<div class="row">
								<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
									<div class="card-sigin">
										<div class="mb-5 d-flex">
                                            <h1 class="main-logo1 ml-1 mr-0 my-auto tx-28">
                                                <span>{{__('Dashboard/login_trans.valex')}}</span>
                                            </h1>
                                        </div>
                                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                            <a class="dropdown" rel="alternate" hreflang="{{ $localeCode }}"
                                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                                @if($properties['native'] == "English")
                                                    <i class="flag-icon flag-icon-us"></i>
                                                @elseif($properties['native'] == "العربية")
                                                    <i class="flag-icon flag-icon-sa"></i>
                                                @endif
                                                {{ $properties['native'] }}
                                            </a>
                                        @endforeach
										<div class="card-sigin">
											<div class="main-signup-header">
                                                <br/>
												<h2>{{trans('Dashboard/login_trans.Welcome')}}</h2>
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul>
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">{{trans('Dashboard/login_trans.Select_Enter')}}</label>
                                                    <select class="form-control" id="sectionChooser">
                                                        <option value="" selected disabled>{{trans('Dashboard/login_trans.Choose_list')}}</option>
                                                        <option value="Register">{{trans('Dashboard/login_trans.register')}}</option>
                                                        <option value="Login">{{trans('Dashboard/login_trans.login')}}</option>
                                                    </select>
                                                </div>
                                                {{--form Register--}}
                                                    <div class="panel" id="Register">
                                                        <h2>{{trans('Dashboard/login_trans.register')}}</h2>
                                                        <form method="POST" action="{{ route('registerstore') }}">
                                                            @csrf

                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/users.name')}}</label>
                                                                <input  class="form-control" placeholder="{{__('Dashboard/merchants.name')}}" type="name" name="name" :value="old('name')" required autofocus>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/login_trans.Email')}}</label>
                                                                <input  class="form-control" placeholder="{{__('Dashboard/merchants.email')}}" type="email" name="email" :value="old('email')" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/login_trans.Password')}}</label>
                                                                <input class="form-control" placeholder="{{__('Dashboard/merchants.password')}}" type="password" name="password" required autocomplete="current-password" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/users.confirmpassword')}}</label>
                                                                <input class="form-control" placeholder="{{__('Dashboard/merchants.confirmpassword')}}" type="password" name="password_confirmation" required autocomplete="current-password" >
                                                            </div>
                                                            <button type="submit" class="btn btn-main-primary btn-block">{{trans('Dashboard/login_trans.SignIn')}}</button>
                                                        </form>
                                                    </div>

                                                {{--form Login--}}
                                                    <div class="panel" id="Login">
                                                        <h2>{{trans('Dashboard/login_trans.login')}}</h2>
                                                        <form method="POST" action="{{ route('loginmerchants') }}">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/login_trans.Email')}}</label> <input  class="form-control" placeholder="{{__('Dashboard/merchants.email')}}" type="email" name="email" :value="old('email')" required autofocus>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>{{trans('Dashboard/login_trans.Password')}}</label> <input class="form-control" placeholder="{{__('Dashboard/merchants.password')}}" type="password" name="password" required autocomplete="current-password" >
                                                            </div>
                                                            <button type="submit" class="btn btn-main-primary btn-block">{{trans('Dashboard/login_trans.SignIn')}}</button>
                                                        </form>
                                                    </div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div><!-- End -->
					</div>
				</div><!-- End -->
			</div>
		</div>
@endsection
@section('js')
    <script>
        $('#sectionChooser').change(function(){
            var myID = $(this).val();
            $('.panel').each(function(){
                myID === $(this).attr('id') ? $(this).show() : $(this).hide();
            });
        });
    </script>
@endsection
