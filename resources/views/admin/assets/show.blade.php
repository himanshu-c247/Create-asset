@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-cogs mr-2"></i>{{ trans('global.show') }} {{ trans('cruds.asset.title') }}</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.id') }}
                        </th>
                        <td class="">
                            {{ $asset->id ?? 'NA'}}
                        </td>
                    </tr>
                   
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <td class="text-capitalize">
                            {{ $asset->name ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle;">
                            Image
                        </th>
                        <td>
                            @if ($asset->getFirstMediaUrl('avatar') != null)
                                <img src="{{ $asset->getFirstMediaUrl('avatar') }}" width="80px">
                            @else
                                <img src="{{ asset('no_image.png') }}" width="80px">
                            @endif
                        </td>
                    </tr>
                    
                    <tr>
                        <th>
                            Category
                        </th>
                        <td class="text-capitalize">
                            {{ $asset->category->name ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Type
                        </th>
                        <td class="text-capitalize">
                            {{ $asset->type ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th style="vertical-align: middle;">
                            {{ trans('cruds.asset.fields.description') }}
                        </th>
                        <td>
                            {{ ucfirst($asset->description) ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Danger level
                        </th>
                        <td>
                            {{ $asset->danger_level ?? 'NA'}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assets.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
