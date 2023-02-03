@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ trans('global.create') }} {{ trans('cruds.asset.title_singular') }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="required" for="name">{{ trans('cruds.asset.fields.name') }}</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name', '') }}">
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
                            @forelse ($categories as $key => $category)
                                @if ($category)
                                    <option value="{{ $category->id }}"{{ old('category_id') == $category->id ? 'selected' : '' }}>{{ ucfirst($category->name) ?? '' }}</option>
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
                    <div class="form-group col-md-6">
                        <label class="required" for="name">Type</label>
                        <select class="form-control" id="type" name="type">
                            <option disabled selected>Select Type</option>
                            <option value="fabric"{{ old('type') == 'fabric' ? 'selected' : '' }}>Fabric</option>
                            <option value="button"{{ old('type') == 'button' ? 'selected' : '' }}>Button</option>
                            <option value="zipper"{{ old('type') == 'zipper' ? 'selected' : '' }}>Zipper</option>
                            
                        </select>
                        @if ($errors->has('type'))
                            <div class="text-danger">
                                {{ $errors->first('type') }}
                            </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.asset.fields.name_helper') }}</span>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="required" for="quantity">Quantity</label>
                        <input class="form-control " type="number" name="quantity" id="quantity"
                            value="{{ old('quantity', 0) }}">
                        @if ($errors->has('quantity'))
                            <div class="text-danger">
                                {{ $errors->first('quantity') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                
                    <div class="form-group col-md-6">
                        <label class="required" for="name"a>Unit</label>
                        <select class="form-control" id="unit" name="unit">
                            <option disabled selected>Select Unit</option>
                            @forelse (App\Asset::Measurement as $key => $value)
                                @if ($value)
                                    <option value="{{ $value }}" {{ old('unit') == $value ? 'selected' : '' }}>
                                        {{ ucfirst($value) ?? '' }}</option>
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
                        <label class="required" for="danger_level">Quantity</label>
                        <input class="form-control " type="number" name="quantity" id="quantity" value="{{ old('quantity') }}">
                        @if ($errors->has('quantity'))
                            <div class="text-danger">
                                {{ $errors->first('quantity') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="required" for="name">Status</label>
                        <select class="form-control" id="status" name="status" value="{{old('status')}}">
                            <option disabled selected>Select Status</option>
                            <option value="1"{{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0"{{ old('status') == '0' ? 'selected' : '' }}>InActive</option>
                            
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
                        <input class="form-control " type="number" name="danger_level" id="danger_level"
                            value="{{ old('danger_level', 0) }}">
                        @if ($errors->has('danger_level'))
                            <div class="text-danger">
                                {{ $errors->first('danger_level') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="danger_level">Image</label>
                        <input type="file" name="avatar" class="form-control">
                        @if ($errors->has('danger_level'))
                            <div class="invalid-feedback">
                                {{ $errors->first('danger_level') }}
                            </div>
                        @endif
                        <span class="help-block"></span>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">{{ trans('cruds.asset.fields.description') }}</label>
                        <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
                            id="description">{{ old('description') }}</textarea>
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
