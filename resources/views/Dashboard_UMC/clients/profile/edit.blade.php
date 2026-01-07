@extends('Dashboard_UMC/layouts.master')
@section('title')
    {{__('Dashboard/profile.Edit-Profile')}}
@endsection
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">{{__('Dashboard/profile.Pages')}} </h4>
                <span class="text-muted mt-1 tx-13 mr-2 mb-0">/ {{__('Dashboard/profile.Edit-Profile')}}</span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm">
        <!-- Col -->
        <div class="col-lg-12">
            <div class="card mg-b-20">
                <div class="card-body">
                    <div class="pl-0">
                        <div class="main-profile-overview">
                                <div class="main-img-user profile-user">
                                        @if (empty($client->image))
                                            <img src="{{URL::asset('assets/img/faces/6.jpg')}}">
                                            <a class="fas fa-camera profile-edit" href=""></a>
                                        @else
                                            <img src="{{URL::asset('storage/'.$client->image)}}">
                                            <a class="fas fa-camera profile-edit" href="JavaScript:void(0);"></a>
                                            <br>
                                            <a class="fas fa-solid fa-trash" href="{{ route('imageclient.delete') }}" style="color: red"></a>
                                            <br>
                                        @endif
                                </div>

                                    @if (empty($client->image))
                                        <form action="{{ route('imageclient.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                            {{ csrf_field() }}

                                            <input type="hidden" value="{{Auth::guard('clients')->user()->id}}" name="id">

                                            <p class="text-danger">* {{__('Dashboard/profile.Attachmentformat')}}  pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title"> {{__('Dashboard/profile.imageuser')}} </h5>

                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="imageclient" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                    data-height="70" />
                                            </div><br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary"> {{__('Dashboard/profile.saveimageuser')}} </button>
                                            </div>
                                        </form>
                                    @else
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <form action="{{ route('imageclient.update') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                            {{ method_field('patch') }}
                                            {{ csrf_field() }}

                                            <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                            <h5 class="card-title"> {{__('Dashboard/profile.imageuserupdate')}} </h5>

                                            <div class="col-sm-12 col-md-12">
                                                <input type="file" name="imageclient" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                                                    data-height="70" />
                                            </div><br>

                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-primary"> {{__('Dashboard/profile.saveimageuser')}} </button>
                                            </div>
                                        </form>
                                    @endif
                        </div><!-- main-profile-overview -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Col -->
        <div class="col-lg-12">
            <div class="py-12">
                <div class="col-lg-12">
                </div>
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('Dashboard_UMC.clients.profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('Dashboard_UMC.clients.profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('Dashboard_UMC.clients.profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Col -->
    </div>
    <!-- row closed -->
@endsection
@section('js')
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('assets/plugins/select2/js/select2.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/select2.js')}}"></script>
@endsection
