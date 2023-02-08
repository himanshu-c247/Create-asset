@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <h4><i class="fas fa-users mr-2"></i>{{ trans('global.create') }} {{ trans('cruds.team.title_singular') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.teams.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.team.fields.name') }}</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
                @error('name')
                <span class="text-danger">
                    {{ $message }}
                </span>
            @enderror
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