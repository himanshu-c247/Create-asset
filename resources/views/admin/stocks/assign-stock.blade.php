<!------------Stock-Modal-------------->
<div class="modal fade" id="assignStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Assign Stock</h4>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="assignStockForm" enctype="multipart/form-data">
                    @csrf
                    @method('Post')
                    <div class="form-group">
                        <label class="required" for="asset">{{ trans('cruds.stock.fields.asset') }}</label>
                        <input class="form-control" type="hidden" name="asset_id" id="asset_id"
                            value="{{ $stock->asset->id }}">
                        <input class="form-control" type="text" value="{{ $stock->asset->name }}" disabled>
                        <span class="text-danger error asset_id-error"></span>
                        <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label class="required" for="team_id">Organization</label>
                        <select class="form-control select2" name="team_id" id="team_id" required>
                            <option selected disabled>Select Organization</option>

                            @foreach ($teams as $team)
                                <option value="{{ $team->id }}">{{ ucwords($team->name) }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger error asset_id-error"></span>
                        <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                    </div>
                    <div class="form-group">
                        {{-- <label for="current_stock">{{ trans('cruds.stock.fields.current_stock') }}</label><small> (<sapn class="fw700">Note:</sapn> Your available stock is {{$stock->current_stock == null ? '0' : $stock->current_stock  }})</small> --}}
                        <div class="d-flex justify-content-left">
                            <div class="form-check">
                                <input class="form-check-input checked" type="radio" value="1" name="stock"
                                    id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                    Add
                                </label>
                            </div>
                            <div class="form-check ml-2">
                                <input class="form-check-input checked" type="radio" value="2" name="stock"
                                    id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                    Remove
                                </label>
                            </div>
                        </div>
                        <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="current_stock">Assign Stock </label><small> (<sapn class="fw700">Note:</sapn> Your
                            available stock is
                            {{ $stock->current_stock == null ? '0' : $stock->current_stock }})</small>
                        <input class="form-control" type="number" name="current_stock" id="current_stock"
                            value="{{ old('current_stock', '') }}" step="1">
                        <span class="text-danger error current_stock-error"></span>
                        <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                    </div>
                    <div class="form-group ml-4 store-check d-none">
                        {{-- <label for="current_stock">Assign Stock </label><small> (<sapn class="fw700">Note:</sapn> Your available stock is {{$stock->current_stock == null ? '0' : $stock->current_stock  }})</small> --}}

                        <input class="form-check-input" type="checkbox" name="checked" value="checked" id="check" checked />
                        <label for="loginCheck">Do you want to add in your corrunt stock?</label>
                    </div>

                    <input class="form-control" type="hidden" name="id" value="{{ $stock->id }}">

                    <div class="form-group text-center">
                        <button class="btn btn-primary assign-stock"
                            data-url="{{ route('admin.stocks.assignStockStore') }}"
                            type="button">{{ trans('global.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
