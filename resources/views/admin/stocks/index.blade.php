@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-cogs mr-2"></i>{{ trans('cruds.stock.title_singular') }}</h4>
        @can('permission_create')
        <div class="filter-search-block d-flex justify-content-between">
            <form method="GET" id="search-form" action="{{route('admin.stocks.index')}}" autocomplete="off">
                <div class="row">
                    <div class="form-group search-group">
                        <div class="search-box">
                            <input type="text" id="search" name="search" value="{{ app('request')->input('search') }}" class="form-control" placeholder="Search by product">
                            <i class="ri-search-line search-icon"></i>
                            <div class="search-via">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <a href=""><button type="button" class="reset-btn btn btn-primary ml-3" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh text-white"></i></button></a> 
             <a><button class="btn btn-primary stock-model ml-2" data-url="{{ route("admin.stocks.create") }}">{{ trans('global.add') }} {{ trans('cruds.stock.title_singular') }}</button></a>
        </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">
                            {{ trans('cruds.stock.fields.s_no') }}
                        </th>
                     
                        <th width="10%">
                            {{ trans('cruds.stock.fields.asset') }}
                        </th>

                        <th width="10%">
                            Catgory
                        </th>
                        {{-- @admin
                            <th>
                                Organization
                            </th>
                        @endadmin --}}
                        <th class="text-center" width="10%">
                            {{ trans('cruds.stock.fields.current_stock') }}
                        </th>
                        <th width="10%">
                            Unit
                        </th>
                        @user
                            {{-- <th class="text-center" width="10%">
                                Add Stock
                            </th> --}}
                            <th class="text-center" width="10%">
                                Remove Stock
                            </th>
                        @enduser
                        <th class="text-center" width="10%">
                            {{ trans('cruds.stock.fields.action') }}   
                        </th>
                    </tr>
                </thead>
                <tbody class="stock-table">
                   @include('admin.stocks.stocktable')
                </tbody>
            </table>
            <div class="text-align-right">
                {{$stocks->links()}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/stock.js') }}"></script>
@endsection
