@extends('layouts.admin')
@section('content')
    @include('sweetalert::alert')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4><i class="fa fa-paper-plane mr-2"></i>Request</h4>
            <div class="filter-search-block d-flex justify-content-between">
                {{-- <form method="GET" id="search-form" action="{{ route('admin.stocks.index') }}" autocomplete="off">
                    <div class="row">
                        <div class="form-group search-group">
                            <div class="search-box">
                                <input type="text" id="search" name="search" value="{{ app('request')->input('search') }}" class="form-control" placeholder="Search by product">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                </form>
                <a><button type="button" class="reset-btn btn btn-primary ml-3" data-toggle="tooltip" data-placement="top"
                        title="Reset"><i class="fa fa-refresh text-white"></i></button></a> --}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="5%">
                                {{ trans('cruds.stock.fields.s_no') }}
                            </th>

                            <th width="35%">
                                {{ trans('cruds.stock.fields.asset') }}
                            </th>

                            <th width="10%">
                                Organization
                            </th>

                            <th width="10%">
                                Catgory
                            </th>

                            <th class="text-center" width="10%">
                                Stock
                            </th>

                            <th width="5%" class="text-center">
                                Unit
                            </th>
                            <th width="10%" class="text-center">
                                status
                            </th>
                            @admin
                            <th class="text-center" width="15%">
                                {{ trans('cruds.stock.fields.action') }}
                            </th>
                            @endadmin
                        </tr>
                    </thead>
                    <tbody class="stock-table">
                        @if (isset($stocks))
                            @forelse($stocks as $key => $stock)
                                <tr>
                                    <td class="text-center">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $stock->asset->name ?? 'NA' }}
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $stock->team->name ?? 'NA' }}
                                    </td>
                                    <td class="text-capitalize">
                                        {{ $stock->asset->category->name ?? 'NA' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $stock->stock ?? 'NA' }}
                                    </td>
                                    <td class="text-capitalize text-center">
                                        {{ $stock->asset->unit ?? 'NA' }}
                                    </td>
                                    <td class="text-capitalize text-center">
                                        <span class="badge badge-primary">{{ $stock->status == '2' ? 'Rejected' : ($stock->status == '0' ? 'Pending' : 'Confirm') }}</span>
                                    </td>
                                  
                                    @admin
                                    <td class="text-center">
                                            <a class="btn btn-xs btn-default accept-request" data-url="{{route('admin.stocks.requestAccept',$stock->id)}}" data-toggle="tooltip"data-placement="top" title="Accept Stock Request"><i class="fa fa-check"></i></a>
                                            <a class="btn btn-xs btn-default" data-url="" data-toggle="tooltip"data-placement="top" title="Reject Stock Request"><i class="fa fa-close"></i></a>
                                    </td>
                                    @endadmin
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="12">
                                        <h4>No Data Found</h4>
                                    </td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="12">
                                    <h4>No Data Found</h4>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="text-align-right">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@parent
<script>
/* =================== Team Delete ======================= */
$(document).on('click', '.accept-request', function () {
    Swal.fire({
        title: 'Are you sure?',
        // text: 'you want to accept stock request',
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Confirm it!',
    }).then((result) => {
        if (result.isConfirmed) {
            var url = $(this).attr('data-url')
           alert(url);
            method = 'GET'
            $.ajax({
                url: url,
                method: method,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function (response) {
                    if (response.status == 'success') {
                        // $('.asset-table').html(response.output)
                        toastr.success(response.message, 'Success!', {
                            timeOut: '4000',
                        })
                    }else{
                        toastr.warning(response.message, 'Error!', {
                            timeOut: '4000',
                        })
                    }
                },
            })
        }
    })
})
    
</script>    
@endsection
