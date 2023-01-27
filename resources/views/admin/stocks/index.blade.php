@extends('layouts.admin')
@section('content')
{{-- @can('stock_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12 mt-2">
            
        </div>
    </div>
@endcan --}}
@include('sweetalert::alert')
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4>{{ trans('cruds.stock.title_singular') }} {{ trans('global.list') }}</h4>
        @can('permission_create')
            <div class="d-flex justify-content-between">
                @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            </div>
        @endcan
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Stock">
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
                        @admin
                            <th>
                                Organization
                            </th>
                        @endadmin
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
                <tbody>
                    @foreach($stocks as $key => $stock)
                        <tr>
                            <td class="text-center">
                                {{ $loop->index + 1 }}
                            </td>
                           
                            <td class="text-capitalize">
                                {{ $stock->asset->name ?? 'NA' }}
                            </td>
                            <td class="text-capitalize">
                                {{ $stock->asset->category->name ?? 'NA' }}
                            </td>
                          
                            @admin
                                <td class="text-capitalize">
                                    {{ $stock->team->name }}
                                </td>
                            @endadmin
                            <td class="text-center">
                                {{ $stock->current_stock ?? 'NA' }}
                            </td>
                            <td class="text-capitalize">
                                {{ $stock->asset->unit ?? 'NA' }}
                            </td>
                            @user
                                <td class="text-center">
                                    <form action="{{ route('admin.transactions.storeStock', $stock->id) }}" method="POST" style="display: inline-block;" class="form-inline">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="action" value="add">
                                        <input type="text" name="stock" class="form-control form-control-sm col-7" min="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"  onkeydown="{{$stock->asset->unit == 'quantity' ? 'if(event.key==="."){event.preventDefault();}' : ' '}}">
                                        <input type="submit" class="btn btn-xs btn-primary text-right" value="ADD">
                                    </form>
                                </td>
                                <td class="text-center">
                                    <form style="display: inline-block;" id="removeStockForm" class="form-inline">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="action" value="remove">
                                        <input type="text" name="stock" class="form-control form-control-sm col-7 stock-value"  min="1" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" onkeydown="{{$stock->asset->unit == 'quantity' ? 'if(event.key==="."){event.preventDefault();}' : ' '}}">
                                        <button type="button" class="btn btn-xs btn-primary remove-stock" data-url="{{ route('admin.transactions.storeStock', $stock->id) }}" data-current-stock={{$stock->current_stock}}>REMOVE</button>
                                    </form>
                                </td>
                            @enduser
                            <td class="text-center">
                                @can('stock_show')
                                    <a class="btn btn-xs btn-default" href="{{ route('admin.stocks.show', $stock->id) }}" data-toggle="tooltip" data-placement="top" title="View">
                                       <i class="fa fa-eye"></i>
                                    </a>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent

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
