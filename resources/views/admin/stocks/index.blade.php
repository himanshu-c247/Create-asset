@extends('layouts.admin')
@section('content')
@include('sweetalert::alert')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.stock.title_singular') }} {{ trans('global.list') }}</h4>
        @can('permission_create')
        <div class="d-flex justify-content-between">
         <button class="btn btn-primary stock-model" data-url="{{ route("admin.stocks.create") }}">{{ trans('global.add') }} {{ trans('cruds.stock.title_singular') }}</button>
        </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="text-center" width="12">
                            {{ trans('cruds.stock.fields.s_no') }}
                        </th>
                     
                        <th>
                            {{ trans('cruds.stock.fields.asset') }}
                        </th>

                        <th>
                            Catgory
                        </th>
                        {{-- @admin
                            <th>
                                Organization
                            </th>
                        @endadmin --}}
                        <th class="text-center">
                            {{ trans('cruds.stock.fields.current_stock') }}
                        </th>
                        <th>
                            Unit
                        </th>
                        @user
                            <th class="text-center">
                                Add Stock
                            </th>
                            <th class="text-center">
                                Remove Stock
                            </th>
                        @enduser
                        <th class="text-center">
                            {{ trans('cruds.stock.fields.action') }}
                            
                        </th>
                    </tr>
                </thead>
                <tbody class="stock-table">
                   @include('admin.stocks.stocktable')
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script src="{{ asset('js/stock.js') }}"></script>
<script>
$('.remove-stock').click(function() {
            var url = $(this).attr('data-url');
            var value = $(this).parents("tr").find('.stock-value').val();
            var currentStock = $(this).attr('data-current-stock');
            if(currentStock - value < 0){
                Swal.fire({
                title: 'Opss...',
                text: "Not enough items in stock!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Inform Admin!'
                })
            }
            else{
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
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    pageLength: 100,
      columnDefs: [{
          orderable: true,
          className: '',
          targets: 0
      }]
  });
  $('.datatable-Stock:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
