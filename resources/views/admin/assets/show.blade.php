@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4>{{ trans('global.show') }} {{ trans('cruds.asset.title') }}</h4>
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
                            {{ $asset->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <td class="text-capitalize">
                            {{ $asset->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.asset.fields.description') }}
                        </th>
                        <td>
                            {{ ucfirst($asset->description) ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Danger level
                        </th>
                        <td>
                            {{ $asset->danger_level }}
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
