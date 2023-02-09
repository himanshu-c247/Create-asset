<!------------Edit-Team-Modal-------------->
<div class="modal fade" id="editTeamModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4><i class="fas fa-users mr-2"></i>{{ trans('global.edit') }} {{ trans('cruds.team.title_singular') }}</h4>
          <button type="button" class="close btn-close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="editTeamForm" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $team->name) }}">
                <span class="text-danger error name-error"></span>
                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary update-team" type="button" data-url="{{ route("admin.teams.update", [$team->id]) }}">
                    {{ trans('global.update') }}
                </button>
            </div>
            </form>
        </div>
      </div>
    </div>
  </div>
