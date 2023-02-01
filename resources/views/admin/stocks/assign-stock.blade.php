<!------------Stock-Modal-------------->
<div class="modal fade" id="assignStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <input class="form-control" type="hidden" name="asset_id" id="asset_id" value="{{$stock->asset->id}}">
                    <input class="form-control" type="text" value="{{$stock->asset->name}}" disabled>
                    <span class="text-danger error asset_id-error"></span>
                    <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="team_id">Organization</label>
                    <select class="form-control select2" name="team_id" id="team_id" required>
                        @foreach($teams as  $team)
                            <option value="{{ $team->id }}">{{ ucwords($team->name) }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger error asset_id-error"></span>
                    <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="current_stock">Assign Stock </label><small> (<sapn class="fw700">Note:</sapn> Your available stock is {{$stock->current_stock == null ? '0' : $stock->current_stock  }})</small>
                    <input class="form-control {{ $errors->has('current_stock') ? 'is-invalid' : '' }}" type="number" name="current_stock" id="current_stock" value="{{ old('current_stock', '') }}" step="1">
                    @if($errors->has('current_stock'))
                        <div class="invalid-feedback">
                            {{ $errors->first('current_stock') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                </div>
                <input class="form-control" type="hidden" name="id" value="{{$stock->id}}">

                <div class="form-group text-center">
                    <button class="btn btn-primary assign-stock" data-url ="{{ route('admin.stocks.assignStockStore') }}" type="button" >{{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>
