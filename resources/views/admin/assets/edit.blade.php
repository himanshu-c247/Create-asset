@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}</h4>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.assets.update", [$asset->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name', $asset->name) }}">
                @if($errors->has('name'))
                    <div class="text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.asset.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $asset->description) }}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="danger_level">Danger level</label>
                <input class="form-control" type="number" name="danger_level" id="danger_level" value="{{ old('danger_level', $asset->danger_level) }}">
                @if($errors->has('danger_level'))
                    <div class="text-danger">
                        {{ $errors->first('danger_level') }}
                    </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group">
                <label class="" for="name">Unit</label>
                <select class="form-control" id="status_id" name="unit">
                    <option disabled selected>Select Unit</option>
                    @forelse (App\Asset::Measurement as $key => $value)
                        @if ($value)
                            <option value="{{ $value }} {{ old('status') == $value ? 'selected' : '' }}">{{ ucfirst($value) ?? '' }}</option>
                        @endif
                    @empty
                    @endforelse
                </select>
                @if($errors->has('unit'))
                    <div class="text-danger">
                        {{ $errors->first('unit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
                <a class="btn btn-default" href="{{ route("admin.assets.index") }}">
                    {{ trans('global.cancel') }}
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
