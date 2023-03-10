@extends('layouts.admin')
@section('content')
    <div class="card">
        
        <div class="card-header"><h4><i class="fas fa-cogs mr-2"></i>{{ trans('global.edit') }} {{ trans('cruds.asset.title_singular') }}</h4></div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.assets.update', [$asset->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                        <input class="form-control" type="text" name="name" id="name"
                            value="{{ old('name', $asset->name) }}">
                        @if ($errors->has('name'))
                            <div class="text-danger">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required" for="name">Category</label>
                        <select class="form-control" id="category_id" name="category_id">
                            <option disabled selected>Select Category</option>
                            @forelse ($categories as $category)
                                @if ($category)
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $asset->category_id ? 'selected' : '' }}>
                                        {{ ucfirst($category->name) ?? '' }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('category_id'))
                            <div class="text-danger">
                                {{ $errors->first('category_id') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    {{-- {{dd($asset->type)}} --}}
                    <div class="form-group col-md-6">
                        <label class="required" for="name">Type</label>
                        <select class="form-control" id="type" name="type">
                            <option disabled selected>Select Type</option>
                            <option value="shirt" {{$asset->type == "shirt" ? 'selected' : '' }}>shirt</option>
                            <option value="t-shirt" {{$asset->type == "t-shirt" ? 'selected' : '' }}>t-shirt</option>
                            <option value="suit" {{$asset->type == "suit" ? 'selected' : '' }}>suit</option>
                            <option value="fabric" {{$asset->type == "fabric" ? 'selected' : '' }}>Fabric</option>
                            <option value="button" {{$asset->type == "button" ? 'selected' : '' }}>Button</option>
                            <option value="zipper" {{$asset->type == "zipper" ? 'selected' : '' }}>Zipper</option>

                        </select>
                        @if ($errors->has('type'))
                            <div class="text-danger">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="" for="name">Unit</label>
                        <select class="form-control" id="unit" name="unit">
                            <option disabled selected>Select Unit</option>
                            @forelse (App\Asset::Measurement as $key => $value)
                                @if ($value)
                                    <option value="{{ $key }}" {{ $key == $asset->unit ? 'selected' : '' }}>
                                        {{ ucfirst($key) ?? '' }}</option>
                                @endif
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('unit'))
                            <div class="text-danger">
                                {{ $errors->first('unit') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="req   uired" for="name">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option disabled selected>Select Status</option>
                            <option value="1" {{ $asset->status == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $asset->status == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @if ($errors->has('status'))
                            <div class="text-danger">
                                {{ $errors->first('status') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required" for="danger_level">Danger level</label>
                        <input class="form-control" type="number" name="danger_level" id="danger_level"
                            value="{{ old('danger_level', $asset->danger_level) }}">
                        @if ($errors->has('danger_level'))
                            <div class="text-danger">
                                {{ $errors->first('danger_level') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                    <div class="col-md-12">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="danger_level">Image</label>
                            <input type="file" name="avatar" class="form-control"
                                value="{{ old('name', $asset->getFirstMediaUrl('avatar')) }}">
                            @if ($errors->has('danger_level'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('danger_level') }}
                                </div>
                            @endif
                            <span class="help-block"></span>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            @if ($asset->getFirstMediaUrl('avatar') != null)
                                <img src="{{ $asset->getFirstMediaUrl('avatar') }}" width="120px">
                            @else
                                <img src="{{ asset('no_image.png') }}" width="120px">
                            @endif
                        </div>
                    </div>
                </div>
                    <div class="form-group col-md-12">
                        <label for="description">{{ trans('cruds.asset.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                            id="description">{{ old('description', $asset->description) }}</textarea>
                        @if ($errors->has('description'))
                            <div class="invalid-feedback">
                                {{ $errors->first('description') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.description_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        {{ trans('global.save') }}
                    </button>
                    <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                        {{ trans('global.cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
