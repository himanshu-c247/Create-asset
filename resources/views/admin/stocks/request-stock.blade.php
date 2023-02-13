<!------------Request-Stock-Modal-------------->
<div class="modal fade" id="requestStockModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="fas fa-cogs mr-2"></i>Request Stock</h4>
                <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="requestStockForm" enctype="multipart/form-data">
                    @csrf
                    @method('Post')
                    <div class="form-group">
                        <label class="required" for="asset">{{ trans('cruds.stock.fields.asset') }}</label>
                        <input class="form-control" type="hidden" name="asset_id" id="asset_id" value="{{ $stock->asset->id }}">
                        <input class="form-control" type="text" value="{{ $stock->asset->name }}" disabled>
                        <span class="text-danger error asset_id-error"></span>
                        <span class="help-block">{{ trans('cruds.stock.fields.asset_helper') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="current_stock">Stock </label><small> (<sapn class="fw700">Note:</sapn> Your available stock is {{ $stock->current_stock == null ? '0' : $stock->current_stock }})</small>
                        <input class="form-control" type="number" name="stock" id="stock"
                            value="{{ old('stock', '') }}" step="1">
                        <span class="text-danger error stock-error"></span>
                        <span class="help-block">{{ trans('cruds.stock.fields.current_stock_helper') }}</span>
                    </div>
                    <input class="form-control" type="hidden" name="id" value="{{ $stock->id }}">
                    <input class="form-control" type="hidden" name="team_id" value="{{ $stock->team_id }}">
                    <div class="form-group text-center">
                        <button class="btn btn-primary request-stock" data-url="{{ route('admin.stocks.requestStockStore') }}" type="button">{{ trans('global.request') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


