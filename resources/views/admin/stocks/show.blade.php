@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
        <h4>{{ trans('global.show') }} {{ trans('cruds.stock.title') }}</h4>
    </div>
    <div class="card-body">
        <div class="form-group">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>{{ trans('cruds.stock.fields.id') }}</th>
                        <th>{{ trans('cruds.stock.fields.asset') }}</th>
                        <th>{{ trans('cruds.stock.fields.current_stock') }}</th>
                        
                    </tr>
                    <tr>
                        <td >
                            {{ $stock->id }}
                        </td>
                        <td class="text-capitalize">
                            {{ $stock->asset->name ?? 'NA' }}
                        </td>
                        <td>
                            {{ $stock->current_stock ?? 'NA' }}
                        </td>
                    </tr>
                   
                </tbody>
            </table>
            <h4 class="text-center">
                History of {{ $stock->asset->name }}
                @if(count($stock->asset->transactions) == 0)
                    is empty
                @endif
            </h4>
            @if(count($stock->asset->transactions) > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="w-75">User</th>
                            <th>Amount</th>
                        </tr>
                        @foreach($stock->asset->transactions as $transaction)
                            <tr>
                                <td class="text-capitalize">
                                    {{ $transaction->user->name }}
                                    {{-- ({{ $transaction->user->email }})
                                    ({{ $transaction->user->team->name }}) --}}
                                </td>
                                <td>{{ $transaction->stock }}</td>
                            </tr>
                        @endforeach
                    </thead>
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
