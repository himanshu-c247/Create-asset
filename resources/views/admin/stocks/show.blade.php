@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4> <i class="fas fa-cogs mr-2"></i>History of {{$stock->asset->name ?? 'NA' }}</h4>
        @can('permission_create')
        <div class="filter-search-block d-flex justify-content-between">
            <form method="GET" id="search-form" action="{{ route('admin.stocks.show', $stock->id) }}" autocomplete="off">
                <div class="row">
                    <div class="form-group search-group">
                        <div class="search-box">
                            <input type="text" id="search" name="search" value="{{ app('request')->input('search') }}" class="form-control" placeholder="Search by organigation">
                            <i class="ri-search-line search-icon"></i>
                            <div class="search-via">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <a href=""><button type="button" class="reset-btn btn btn-primary ml-3" data-toggle="tooltip" data-placement="top" title="Reset"><i class="fa fa-refresh text-white"></i></button></a> 
        </div>
        @endcan
    </div>
    <div class="card-body">
        <div class="form-group">
            {{-- <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.stock.fields.id') }}</th>
                        <th>{{ trans('cruds.stock.fields.asset') }}</th>
                        <th>Category</th>
                        <th>{{ trans('cruds.stock.fields.current_stock') }}</th>
                    </tr>
                    <tr>
                        <td >
                            {{ $stock->id }}
                        </td>
                        <td class="text-capitalize">
                            {{ $stock->asset->name ?? 'NA' }}
                        </td>
                        <td class="text-capitalize">
                            {{ $stock->asset->category->name ?? 'NA' }}
                        </td>
                        <td>
                            {{ $stock->current_stock ?? 'NA' }}
                        </td>
                    </tr>
                   
                </tbody>
            </table> --}}
            {{-- <h4 class="text-center">
                History of {{ $stock->asset->name }}
                @if(count($stock->asset->transactions) == 0)
                    is empty
                @endif
            </h4> --}}
            @if(count($stock->asset->transactions) > 0)
                <table class="table table-bordered table-striped table-hover datatable datatable-Stock">
                    <thead>
                        <tr>
                            <th class="text-center">S.No</th>
                            <th>Asset</th>
                            <th>Organigation</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Date</th>
                        </tr>
                    </thead>
                    <tbody class="stock-history">    
                      @include('admin.stocks.stock-history-table')
                    </tbody>
                </table>
            @endif
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.stocks.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/stock.js') }}"></script>
<script>
    /* =========== Leave History Search =========== */
    var searchFilter = function() {
        var form_action = $("#search-form").attr("action");
        $.ajax({
            url: form_action,
            type: "GET",
            dataType: 'json',
            data: $('#search-form').serialize(),
            success: function(data) {
                $('.stock-history').html(data.historySearch);
            },
        });
    }
    $(document).on('keyup', '#search', function() {
        searchFilter();
    });
</script>
@endsection
