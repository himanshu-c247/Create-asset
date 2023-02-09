<!------------User-Modal-------------->
<div class="modal fade user-modal-create" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-user mr-2"></i>{{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}</h4>
          <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="addUserForm" enctype="multipart/form-data">
                @csrf
                @method('Post')
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                    @if($errors->has('name'))
                        <div class="text-danger">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                    <input class="form-control" type="email" name="email" id="email" value="{{ old('email','') }}">
                    @if($errors->has('email'))
                        <div class="text-danger">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                    <input class="form-control" type="password" name="password" id="password" >
                    @if($errors->has('password'))
                        <div class="text-danger">
                            {{ $errors->first('password') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="name">Segment</label>
                    <select class="form-control" id="segment_id" name="segment_id">
                        <option disabled selected>Select Segment</option>
                        @forelse ($segments as $segment)
                            @if ($segment)
                                <option value="{{ $segment->id }} {{ old('segment_id') }}">{{ ucfirst($segment->name) ?? '' }}</option>
                            @endif
                        @empty
                        @endforelse
                    </select>
                    @if($errors->has('segment_id'))
                        <div class="text-danger">
                            {{ $errors->first('segment_id') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2" name="roles[]" id="roles" multiple>
                        @foreach($roles as $id => $roles)
                            <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('roles'))
                        <div class="text-danger">
                            {{ $errors->first('roles') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="team_id">{{ trans('cruds.user.fields.team') }}</label>
                    <select class="form-control select2" name="team_id" id="team_id">
                        @foreach($teams as $id => $team)
                            <option value="{{ $id }}" {{ old('team_id') == $id ? 'selected' : '' }}>{{ $team }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('team'))
                        <div class="text-danger">
                            {{ $errors->first('team') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.user.fields.team_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary store-user" type="button" data-url="{{ route("admin.users.store") }}">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
      </div>
    </div>
  </div>



