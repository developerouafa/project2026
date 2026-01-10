<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{trans('Dashboard/sections_trans.add_sections')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Sections.store') }}" method="post" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <label for="name_en">{{trans('Dashboard/sections_trans.section_english')}}</label>
                    <input type="text" class="form-control" value="{{old('name_en')}}" class="form-control @error('name_en') is-invalid @enderror" id="name_en" name="name_en" placeholder="{{__('Dashboard/sections_trans.section_english')}}">
                </div>
                <div class="modal-body">
                    <label for="name_ar">{{trans('Dashboard/sections_trans.section_arabic')}}</label>
                    <input type="text" class="form-control" class="form-control" value="{{old('name_ar')}}" class="form-control @error('name_ar') is-invalid @enderror" id="name_ar" name="name_ar" placeholder="{{__('Dashboard/sections_trans.section_arabic')}}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('Dashboard/sections_trans.Close')}}</button>
                    <button type="submit" class="btn btn-primary">{{trans('Dashboard/sections_trans.submit')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
