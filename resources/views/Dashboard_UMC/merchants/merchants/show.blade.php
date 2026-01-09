@extends('Dashboard/layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{__('message.showuser')}}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('merchant.index') }}">{{__('Dashboard/merchants.back')}}</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Dashboard/merchants.name')}}</strong>
                {{ $merchant->name }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Dashboard/merchants.Email')}}</strong>
                {{ $merchant->email }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>{{__('Dashboard/merchants.roles')}}</strong>
                @if(!empty($merchant->getRoleNames()))
                @foreach($merchant->getRoleNames() as $v)
                <label class="badge badge-success">{{ $v }}</label>
                @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
