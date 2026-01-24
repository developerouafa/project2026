<div>
    @if ($ServiceSaved)
        <div class="alert alert-info"> {{__('Dashboard/services.dataaddsuccessfully')}} </div>
    @endif

    @if ($ServiceUpdated)
        <div class="alert alert-info"> {{__('Dashboard/services.dataeditsuccessfully')}} </div>
    @endif

    @if($show_table)
        @include('livewire.Dashboardumc.merchants.GroupProducts.index')
    @else
        <form wire:submit.prevent="saveGroup" autocomplete="off">
            @csrf
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-6">
                        <label> {{__('Dashboard/services.namegroupen')}}</label>
                        <input wire:model="name_group_en" type="text" name="name_group_en" class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label> {{__('Dashboard/services.namegroupar')}}</label>
                        <input wire:model="name_group_ar" type="text" name="name_group_ar" class="form-control">
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-6">
                        <label> {{__('Dashboard/services.descen')}}</label>
                        <textarea wire:model="notes_en" name="notes_en" class="form-control" rows="5"></textarea>
                    </div>
                    <div class="col-lg-6">
                        <label> {{__('Dashboard/services.descar')}}</label>
                        <textarea wire:model="notes_ar" name="notes_ar" class="form-control" rows="5"></textarea>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="card mt-4">
                <div class="card-header">
                    <div class="col-md-12">
                        <button class="btn btn-outline-primary" wire:click.prevent="addService">
                                Add Package Products
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr class="table-primary">
                                <th>Name Package Products</th>
                                <th width="200">{{__('Dashboard/services.number')}}</th>
                                <th width="200"> {{__('Dashboard/services.Processes')}} </th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($GroupsItems as $index => $groupItem)
                                    <tr>
                                        <td>
                                            @if($groupItem['is_saved'])
                                                <input type="hidden" name="GroupsItems[{{$index}}][id]"
                                                    wire:model="GroupsItems.{{$index}}.id"/>
                                                @if($groupItem['name'] && $groupItem['price'])
                                                    {{ $groupItem['name'] }}
                                                    ({{ number_format($groupItem['price'], 2) }})
                                                @endif
                                            @else
                                                <select name="GroupsItems[{{$index}}][id]"
                                                        class="form-control{{ $errors->has('GroupsItems.' . $index) ? ' is-invalid' : '' }}"
                                                        wire:model="GroupsItems.{{$index}}.id">
                                                    <option value="">-- {{__('Dashboard/services.Choosefromthelist')}} --</option>
                                                    @foreach ($allProducts as $service)
                                                        <option value="{{ $service->id }}">
                                                            {{ $service->name }}
                                                            ({{ number_format($service->price, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if($errors->has('GroupsItems.' . $index))
                                                    <em class="invalid-feedback">
                                                        {{ $errors->first('GroupsItems.' . $index) }}
                                                    </em>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($groupItem['is_saved'])
                                                <input type="hidden" name="GroupsItems[{{$index}}][quantity]"
                                                    wire:model="GroupsItems.{{$index}}.quantity"/>
                                                {{ $groupItem['quantity'] }}
                                            @else
                                                <input type="number" name="GroupsItems[{{$index}}][quantity]"
                                                    class="form-control" wire:model="GroupsItems.{{$index}}.quantity"/>
                                            @endif
                                        </td>
                                        <td>
                                            @if($groupItem['is_saved'])
                                                <button class="btn btn-sm btn-primary"
                                                        wire:click.prevent="editService({{$index}})">
                                                        {{__('Dashboard/services.update')}}
                                                </button>
                                            @elseif($groupItem['id'])
                                                <button class="btn btn-sm btn-success mr-1"
                                                        wire:click.prevent="saveService({{$index}})">
                                                        {{__('Dashboard/services.submit')}}
                                                </button>
                                            @endif
                                            <button class="btn btn-sm btn-danger"
                                                    wire:click.prevent="removeService({{$index}})">{{__('Dashboard/services.delete')}}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="col-lg-4 ml-auto text-right">
                        <table class="table pull-right">
                            <tr>
                                <td style="color: red">{{__('Dashboard/services.Total')}}</td>
                                <td>{{ number_format($subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td style="color: red">{{__('Dashboard/services.discountvalue')}}</td>
                                <td width="125">
                                    <input type="number" name="discount_value" class="form-control w-75 d-inline"
                                           wire:model="discount_value">
                                </td>
                            </tr>
                            <tr>
                                <td style="color: red"{{__('Dashboard/services.Taxrate')}}</td>
                                <td>
                                    <input type="number" name="taxes" class="form-control w-75 d-inline" min="0"
                                           max="100" wire:model="taxes"> %
                                </td>
                            </tr>
                            <tr>
                                <td style="color: red">{{__('Dashboard/services.Totalwithtax')}}</td>
                                <td>{{ number_format($total, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <br/>
                    <div>
                        <input class="btn btn-outline-success" type="submit" value="{{__('Dashboard/services.save')}}">
                    </div>
                </div>
            </div>

        </form>
    @endif
</div>

