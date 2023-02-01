<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\{Stock,User};
use App\Asset;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Requests\MassDestroyStockRequest;
use App\Team;
use Symfony\Component\HttpFoundation\Response;

class StocksController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('stock_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $teamId = auth()->user()->team_id;
        if($teamId == null){
            $stocks = Stock::with('asset')->where('team_id',null)->latest()->get();
        }else{
            $stocks = Stock::with('asset')->where('team_id',$teamId)->latest()->get();
        }
        return view('admin.stocks.index', compact('stocks'));
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
        $stock = Stock::create($request->all());
        $stock->refresh();
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

    public function show(Stock $stock)
    {
        abort_if(Gate::denies('stock_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

          $stock->load('asset.transactions.user.team');

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
     return $request; 
        
    }
}
