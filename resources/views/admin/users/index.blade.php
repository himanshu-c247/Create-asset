@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="title"><i class="fas fa-user mr-2" data-feather="phone"></i>{{ trans('cruds.user.title_singular') }}</h4>
        @can('user_create')
            <div class="d-flex justify-content-between">
                <div class="filter-search-block d-flex justify-content-between">
                    <form method="GET" id="search-form" action="{{route('admin.users.index')}}" autocomplete="off">
                        <div class="row">
                            <div class="form-group search-group">
                                <div class="search-box">
                                    <input type="text" id="search" name="search" value="{{ app('request')->input('search') }}" class="form-control" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                    <div class="search-via">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <a href=""><button type="button" class="reset-btn btn btn-primary ml-3" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh text-white"></i></button></a> 
                    <a href="{{ route("admin.users.create") }}"><button class="btn btn-primary stock-model ml-2">{{ trans('global.add') }} {{ trans('cruds.user.title_singular') }}</button></a>
                </div>    
            </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        
                        <th class="text-center">
                            {{ trans('cruds.user.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.segment') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.roles') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.user.fields.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="user-table">
                   @include('admin.users.user-table')
                </tbody>
            </table>
            <div class="text-align-right">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/user.js') }}"></script>
@endsection