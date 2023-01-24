@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ trans('global.edit') }} {{ trans('cruds.permission.title_singular') }}</h4>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.permissions.update", [$permission->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.permission.fields.title') }}</label>
                <input class="form-control" type="text" name="title" id="title" value="{{ old('title', $permission->title) }}">
                @if($errors->has('title'))
                    <div class="text-danger">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.permission.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-default" href="{{ route("admin.permissions.index") }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection