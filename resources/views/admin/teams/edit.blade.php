@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <h4>{{ trans('global.edit') }} {{ trans('cruds.team.title_singular') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.update", [$team->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $team->name) }}">
                @if($errors->has('name'))
                    <div class="text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.team.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-default" href="{{ route("admin.teams.index") }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>



@endsection