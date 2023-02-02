<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Team;
use App\Asset;
use App\Category;
use App\{Stock, Transaction, User};
use Illuminate\Http\Request;
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
        if($teamId == null){
            $search = $request['search'];
            $stocks = Stock::with('asset');
            if ($request['search']) 
            {
                $stocks = $stocks->with([ 'asset' => function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                },])->whereHas('asset', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
            }
            $stocks = $stocks->where('team_id',null)->latest()->paginate(15); 
            if ($request->ajax()) {
                $stockSearch = view('admin.stocks.stocktable', compact('stocks'))->render();
                return response()->json(['stockSearch' => $stockSearch]);
            }
            return view('admin.stocks.index', compact('stocks')); 
        }else{
            $stocks = Stock::with('asset')->where('team_id',$teamId)->latest()->get();
            return view('admin.stocks.index', compact('stocks'));
        }
    }

    public function create()
    {
        abort_if(Gate::denies('stock_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories=Category::get();
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $stockModel = view('admin.stocks.create',compact('assets','categories'))->render();
        return response()->json(['status' => 'success','output' => $stockModel]);
    }
    
    public function store(StoreStockRequest $request)
    {
        $data = [
            'current_stock' => $request['current_stock'],
            'asset_id' => $request['asset_id'],
        ];
        $stock = Stock::where('asset_id',$request->asset_id)->first();
        if($stock == null){
            $stock = Stock::create($data);
        }else{
            $addStock = $stock->current_stock + $request->current_stock;
            $stock = $stock->update(['current_stock' => $addStock]);
        }
        $stocks = Stock::with('asset')->where('team_id',null)->latest()->paginate(15);
        $stockTable = view('admin.stocks.stocktable',compact('stocks'))->render();
        return response()->json(['status' => 'success','message' => 'Stock added successfully !','output' => $stockTable]);
    }

    public function edit(Stock $stock)
    {
        abort_if(Gate::denies('stock_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $stock->load('asset', 'team');
        $categories=Category::get();
        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $stockModel = view('admin.stocks.edit',compact('assets','stock','categories'))->render();
        return response()->json(['status' => 'success','output' => $stockModel]);
    }

    public function update(UpdateStockRequest $request, Stock $stock)
    {
        $stock->update($request->all());
        $stock->refresh();
        $stocks = Stock::with('asset')->where('team_id',null)->latest()->paginate(15);
        $stockTable = view('admin.stocks.stocktable',compact('stocks'))->render();
        return response()->json(['status' => 'success','message' => 'Stock Updated successfully !','output' => $stockTable]);
    }

    public function show(Request $request,Stock $stock)
    {
        abort_if(Gate::denies('stock_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $stock->with('asset.transactions.user.team');
        // $search = $request['search'];
        // if ($request['search']) 
        // {
        //     $stock->with([ 'asset.transactions.user.team' => function ($q) use ($search) {
        //         $q->where('team', 'like', '%' . $search . '%');
        //     },])->whereHas('team', function ($q) use ($search) {
        //         $q->where('name', 'like', '%' . $search . '%');
        //     });
        // }
        // $stock->get(); 
        // if ($request->ajax()) {
        //     $historySearch = view('admin.stocks.stock-history-table', compact('stock'))->render();
        //     return response()->json(['historySearch' => $historySearch]);
        // }
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
        $teams = Team::get();
        $assignStockModel = view('admin.stocks.assign-stock',compact('teams','stock'))->render();
        return response()->json(['status' => 'success','output' => $assignStockModel]);
        
    }
    public function assignStockStore(Request $request)
    {
        $stockData = [
            'current_stock' => $request['current_stock'],
            'asset_id'      => $request['asset_id'],
            'team_id'       => $request['team_id'],
        ];
        $transaction = [
            'stock'         => '+'.$request['current_stock'],
            'asset_id'      => $request['asset_id'],
            'team_id'       => $request['team_id'],
        ];
        $stock = Stock::find($request->id);
        if( $request->current_stock <= $stock->current_stock){
            $currentStock = $stock->current_stock - $request->current_stock; 
            $updateStock = $stock->update(['current_stock' => $currentStock]);
            $userStock = Stock::where('team_id',$request->team_id)->first();
            if($userStock == null){
                $stock=Stock::create($stockData);
            $stock->refresh();
            $transaction=Transaction::create($transaction);
        }else{
        $addStock = $userStock->current_stock + $request->current_stock;
           $userStock=$userStock->update(['current_stock'=> $addStock]);
           $transaction=Transaction::create($transaction);
           $stock->refresh();
        }
        $stocks = Stock::with('asset')->where('team_id',null)->latest()->paginate(15);
        $stockTable = view('admin.stocks.stocktable',compact('stocks'))->render();
        return response()->json(['status' => 'success','message' => 'Stock added successfully !','output' => $stockTable]);
        }else{
            return response()->json(['status' => 'error','message' => 'Stock not available']);
        }
        
    }
}