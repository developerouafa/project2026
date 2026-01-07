    <div class="modal-header">
        <h5 class="modal-title">{{trans('Dashboard/profile.delete_account')}}</h5>
    </div>
    <form action="{{ route('profileclient.destroy', 'test') }}" method="post">
        {{ method_field('delete') }}
        {{ csrf_field() }}
        <input type="hidden" name="id" value="{{ auth()->guard('clients')->user()->id }}">
        <div class="modal-footer">
            <button type="submit" class="btn btn-danger">{{trans('Dashboard/profile.delete')}}</button>
        </div>
    </form>
