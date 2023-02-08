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
                $('.stock-table').html(data.stockSearch);
            },
        });
    }
    $(document).on('keyup', '#search', function() {
        searchFilter();
    });
</script>
<script>
    $('.remove-stock').click(function() {
        var url = $(this).attr('data-url');
        var value = $(this).parents("tr").find('.stock-value').val();
        var currentStock = $(this).attr('data-current-stock');
        if (currentStock - value < 0) {
            Swal.fire({
                title: 'Opss...',
                text: "Not enough items in stock!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Inform Admin!'
            })
        } else {
            $.ajax({
                url: url,
                method: 'POST',
                data: $('#removeStockForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data) {
                    toastr.success(data.message, 'Success!', {
                            timeOut: '4000',
                        }),
                        location.reload();
                }
            })
        }

    });
</script>
<script>
    $(function() {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

        $.extend(true, $.fn.dataTable.defaults, {
            pageLength: 100,
            columnDefs: [{
                orderable: true,
                className: '',
                targets: 0
            }]
        });
        $('.datatable-Stock:not(.ajaxTable)').DataTable({
            buttons: dtButtons
        })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
