<!------------Team-Modal-------------->
<div class="modal fade team-modal-create" id="createTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-users mr-2"></i>{{ trans('global.create') }} {{ trans('cruds.team.title_singular') }}</h4>
          <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">
            <form id="addTeamForm" enctype="multipart/form-data">
                 @csrf
                @method('Post')
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                    <span class="text-danger error name-error"></span>
                    <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
                </div>
                <div class="form-group text-center">
                    <button class="btn btn-primary store-team" type="button" data-url="{{ route("admin.teams.store") }}">{{ trans('global.save') }}</button>
                </div>   
            </form>
            {{-- <form id="addStockForm" enctype="multipart/form-data">
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
                <input class="form-control" type="hidden" name="team_id" id="team_id" value="{{ auth()->user()->team_id}}">

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
            </form> --}}
        </div>
      </div>
    </div>
  </div>



