<!------------Stock-Modal-------------->
<div class="modal fade modal-create" id="addStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-cogs mr-2"></i>{{ trans('global.create') }} {{ trans('cruds.stock.title_singular') }}</h4>
          <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addStockForm" enctype="multipart/form-data">
                @csrf
                @method('Post')
                <div class="form-group">
                    <label class="required" for="asset_id">{{ trans('cruds.stock.fields.asset') }}</label>
                    <select class="form-control select2 {{ $errors->has('asset') ? 'is-invalid' : '' }}" name="asset_id" id="asset_id" required>
                        @foreach($assets as $id => $asset)
                            <option value="{{ $id }}">{{ ucwords($asset) }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error asset_id-error"></span>
                    <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="current_stock">{{ trans('cruds.stock.fields.current_stock') }}</label>
                    <input class="form-control {{ $errors->has('current_stock') ? 'is-invalid' : '' }}" type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', '') }}" step="1">
                    @if($errors->has('current_stock'))
                        <div class="invalid-feedback">
                            {{ $errors->first('current_stock') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary store-stock" type="button" data-url="{{ route("admin.stocks.store") }}">{{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
