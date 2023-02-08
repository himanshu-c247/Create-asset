<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Team;
use App\Asset;
use App\Category;
use Illuminate\Http\Request;
use App\{Stock, Transaction, User};
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Requests\MassDestroyStockRequest;
use Symfony\Component\HttpFoundation\Response;

class StocksController extends Controller
{
    public function index(Request $request)
    {

        abort_if(Gate::denies('stock_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
         $teamId = auth()->user()->team_id;
        if ($teamId == '1') {
            $search = $request['search'];
            $stocks = Stock::with('asset');
            if ($request['search']) {
                $stocks = $stocks->with(['asset' => function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                },])->whereHas('asset', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
            $stocks = $stocks->where('team_id', 1)->latest()->paginate(config('app.paginate'));
            if ($request->ajax()) {
                $stockSearch = view('admin.stocks.stocktable', compact('stocks'))->render();
                return response()->json(['stockSearch' => $stockSearch]);
            }
            return view('admin.stocks.index', compact('stocks'));
        } else {
            $stocks = Stock::with('asset')->where('team_id', $teamId)->latest()->paginate(config('app.paginate'));
            return view('admin.stocks.index', compact('stocks'));
        }
    }

    public function create()
    {
        abort_if(Gate::denies('stock_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories = Category::get();
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $stockModel = view('admin.stocks.create', compact('assets', 'categories'))->render();
        return response()->json(['status' => 'success', 'output' => $stockModel]);
    }

    public function store(StoreStockRequest $request)
    {
        $stock = Stock::where('asset_id', $request->asset_id)->first();
        if ($stock) {
            $addStock = $stock->current_stock + $request->current_stock;
            $stock = $stock->update(['current_stock' => $addStock]);
        }
        $data = [
            'stock' => $request['current_stock'],
            'asset_id' => $request['asset_id'],
            'team_id'  => auth()->user()->team_id,
            'user_id' =>  auth()->user()->id,
        ];
        $transaction = Transaction::create($data);
        $stocks = Stock::with('asset')->where('team_id', 1)->latest()->paginate(15);
        $stockTable = view('admin.stocks.stocktable', compact('stocks'))->render();
        return response()->json(['status' => 'success', 'message' => 'Stock added successfully !', 'output' => $stockTable]);
    }

    public function edit(Request $request, Stock $stock)
    {
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $stock->load('asset', 'team');
        $categories = Category::get();
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $stockModel = view('admin.stocks.edit', compact('assets', 'stock', 'categories'))->render();
        return response()->json(['status' => 'success', 'output' => $stockModel]);
    }

    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $sign = $request->stock == '1' ? '+' : '-';
        $stockAmount = $request->current_stock;
        $tansaction=[
            'stock'    => $sign . $stockAmount,
            'asset_id' => $stock->asset->id,
            'team_id'  => $stock->team->id,
            'user_id'  => auth()->user()->id,
        ];
        if ($request->stock == '1') {
            $stock->increment('current_stock', $stockAmount);
            $status = $stockAmount . ' items added to stock.';
            Transaction::create($tansaction);
        }
        if ($request->stock == '2') {
            if (($stock->current_stock - $stockAmount) < 0) {
                return response()->json(['status' => 'error', 'message' => 'Not enough items in stock',]);
            }

            $stock->decrement('current_stock', $stockAmount);
            $status = $stockAmount . ' items removed from stock.';
            Transaction::create($tansaction);

        }
        $stocks = Stock::with('asset')->where('team_id', 1)->latest()->paginate(15);
        $stockTable = view('admin.stocks.stocktable', compact('stocks'))->render();
        return response()->json(['status' => 'success', 'message' => $status, 'output' => $stockTable]);
    }

    public function show(Request $request, Stock $stock)
    {
        abort_if(Gate::denies('stock_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // $stock = $stock->with('asset.transactions.user.team'); 
        // $search = $request['search'];
        // if ($request['search']) 
        // {
        //     $stock = $stock->with([ 'asset.transactions.team' => function ($q) use ($search) {
        //         $q->where('name', 'like', '%' . $search . '%');
        //     },])->whereHas('asset', function ($q) use ($search) {
        //         $q->whereHas('transactions', function ($r) use ($search) {
        //             $r->whereHas('team', function ($s) use ($search) {
        //                     $s->where('name', 'LIKE', '%'. $search .'%');
        //             });
        //         });
        //     });
        // }
        // $stock = $stock->first(); 
        // if ($request->ajax()) {
        //     $historySearch = view('admin.stocks.stock-history-table', compact('stock'))->render();
        //     return response()->json(['historySearch' => $historySearch]);
        // }
        // return view('admin.stocks.show', compact('stock'));

        $stock->with('asset.transactions.user.team');
        return view('admin.stocks.show', compact('stock'));
    }

    public function destroy(Stock $stock)
    {
        abort_if(Gate::denies('stock_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stock->delete();

        return back()->with(['success' => 'Stock Deleted Successfully']);
    }

    public function massDestroy(MassDestroyStockRequest $request)
    {
        Stock::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function assignStock($id)
    {
        $stock = Stock::with('asset')->find($id);
        $teams = Team::where('id', '!=', 1)->get();
        $assignStockModel = view('admin.stocks.assign-stock', compact('teams', 'stock'))->render();
        return response()->json(['status' => 'success', 'output' => $assignStockModel]);
    }
    public function assignStockStore(Request $request)
    {
        $sign = $request->stock == '1' ? '+' : '-';
        $stockAmount = $request->current_stock;
        $stockData = [
            'current_stock' => $stockAmount,
            'asset_id'      => $request['asset_id'],
            'team_id'       => $request['team_id'],
        ];
        $transaction = [
            'stock'         => $sign . $stockAmount,
            'asset_id'      => $request['asset_id'],
            'team_id'       => $request['team_id'],
        ];
        $stock = Stock::find($request->id);
        if($request->current_stock <= $stock->current_stock) {
            $userStock = Stock::where('team_id', $request->team_id)->first();
            if ($userStock == null) {
                $stock->decrement('current_stock', $stockAmount);
                $stock = Stock::create($stockData);
                $stock->refresh();
                $status = $stockAmount . 'items added to stock.';
                $transaction = Transaction::create($transaction);
            }else {
                if ($request->stock == '1') {
                    $stock->decrement('current_stock', $stockAmount);
                    $userStock->increment('current_stock', $stockAmount);
                    $status = $stockAmount . 'items added to stock.';
                }
                else{
                    if (($userStock->current_stock - $stockAmount) < 0) {
                        return response()->json(['status' => 'error', 'message' => 'Not enough stocks in organization']);
                    }
                    $userStock->decrement('current_stock', $stockAmount);
                    $status = $stockAmount . ' items removed from stock.';
                    if($request->checked == 'checked'){
                        $stock->increment('current_stock', $stockAmount);
                    }
                }
                $transaction = Transaction::create($transaction);
            }
            $stocks = Stock::with('asset')->where('team_id', 1)->latest()->paginate(15);
            $stockTable = view('admin.stocks.stocktable', compact('stocks'))->render();
            return response()->json(['status' => 'success', 'message' => $status, 'output' => $stockTable]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Stock not available']);
        }
    }
}
