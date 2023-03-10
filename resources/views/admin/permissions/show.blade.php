@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-unlock mr-2"></i>{{ trans('global.show') }} {{ trans('cruds.permission.title') }}</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
     
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.id') }}
                        </th>
                        <td class="text-capitalize">
                            {{ $permission->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.permission.fields.title') }}
                        </th>
                        <td class="text-capitalize">
                            {{ str_replace('_',' ',$permission->title) ?? 'NA' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.permissions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection