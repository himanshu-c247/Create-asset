@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="title"><i class="fas fa-users mr-2" data-feather="phone"></i>{{ trans('cruds.team.title_singular') }}</h4>
        @can('team_create')
        <div class="filter-search-block d-flex justify-content-between">
            <form method="GET" id="search-form" autocomplete="off">
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
            <a><button class="btn btn-primary team-model ml-2" data-url="{{ route("admin.teams.create") }}">{{ trans('global.add') }} {{ trans('cruds.team.title_singular') }}</button></a>
        </div>    
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="10" class="text-center">
                            {{ trans('cruds.team.fields.s_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.team.fields.name') }}
                        </th>
                        <th class="text-center">
                            {{ trans('cruds.team.fields.action') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="team-table">
                   @include('admin.teams.teamtable')
                </tbody>
            </table>
            <div class="text-align-right">
                {{$teams->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/team.js') }}"></script>
@endsection