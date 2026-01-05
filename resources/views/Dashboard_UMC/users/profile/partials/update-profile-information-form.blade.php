<div class="card">
    <div class="card-body">
        <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" autocomplete="off">
            @csrf
            @method('patch')
            <div class="mb-4 main-content-label">{{__('Dashboard/profile.personalinformation')}}</div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">{{__('Dashboard/profile.name')}}</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="name_{{app()->getLocale()}}" required="" class="form-control" value="{{Auth::user()->name}}"  autofocus autocomplete="name" >
                            <x-input-error class="mt-2" :messages="$errors->get('name_{{app()->getLocale()}}')" />
                        </div>
                    </div>
                </div>
                <div class="form-group ">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">{{__('Dashboard/profile.phone')}}</label>
                        </div>
                        <div class="col-md-9">
                            <input type="text" name="phone" class="form-control" value="{{Auth::user()->phone}}" autofocus autocomplete="phone" >
                            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">{{__('Dashboard/profile.Update Profile')}}</button>
                    </div>
                </div>
        </form>
    </div>
</div>
