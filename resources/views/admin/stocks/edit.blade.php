<!------------Stock-Modal-------------->
<div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-cogs mr-2"></i>{{ trans('global.edit') }} {{ trans('cruds.stock.title_singular') }}</h4>
          <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="editStockForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="required" for="asset_id">{{ trans('cruds.stock.fields.asset') }}</label>
                    <input class="form-control" type="text" name="asset_id" id="asset_id" value="{{$stock->asset->name}}" disabled>
                    <input class="form-control" type="hidden" name="asset_id" id="asset_id" value="{{$stock->asset_id}}">
                    <span class="text-danger error asset_id-error"></span>
                    <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="current_stock">{{ trans('cruds.stock.fields.current_stock') }}</label><small> (<sapn class="fw700">Note:</sapn> Your available stock is {{$stock->current_stock == null ? '0' : $stock->current_stock  }})</small>
                  <div class="d-flex justify-content-left">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" value="1" name="stock" id="flexRadioDefault1" checked>
                        <label class="form-check-label" for="flexRadioDefault1">
                          Add
                        </label>
                      </div>
                      <div class="form-check ml-2">
                        <input class="form-check-input" type="radio" value="2" name="stock" id="flexRadioDefault2" >
                        <label class="form-check-label" for="flexRadioDefault2">
                          Remove
                        </label>
                      </div>
                  </div>  
                  <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                </div>
                <div class="form-group">
                  <label for="current_stock">Stock</label>
                  <input class="form-control {{ $errors->has('current_stock') ? 'is-invalid' : '' }}" type="number" name="current_stock" id="current_stock">
                  <span class="text-danger error current_stock-error"></span>
                  <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                </div>
              
                <div class="form-group text-center">
                    <button class="btn btn-primary update-stock" type="button" data-url="{{ route("admin.stocks.update", [$stock->id]) }}">{{ trans('global.update') }}</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
