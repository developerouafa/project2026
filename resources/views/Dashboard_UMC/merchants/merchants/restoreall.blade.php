<!-- Modal -->
<div class="modal fade" id="restore" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('Dashboard/messages.restore') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('merchant.restoreallselectmerchants', 'test') }}" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                    <h5>{{trans('Dashboard/sections_trans.aresuredeleting')}}</h5>
                    <input type="hidden" id="restore_select_id" name="restore_select_id" value=''>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-info">{{trans('Dashboard/messages.restore')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
