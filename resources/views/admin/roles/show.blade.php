@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
       <h4><i class="fas fa-briefcase mr-2"></i>{{ trans('global.show') }} {{ trans('cruds.role.title') }}</h4>
    </div>

    <div class="card-body">
        <div class="form-group"> 
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.id') }}
                        </th>
                        <td >
                            {{ $role->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.title') }}
                        </th>
                        <td class="text-capitalize">
                            {{ $role->title ?? 'NA' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.role.fields.permissions') }}
                        </th>
                        <td class="text-capitalize">
                            @foreach($role->permissions as $key => $permissions)
                                <span class="label label-info">{{ str_replace('_',' ',$permissions->title) ?? 'NA' }} ,</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.roles.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection