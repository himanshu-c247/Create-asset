<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Asset;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssetRequest;
use App\Http\Requests\UpdateAssetRequest;
use App\Http\Requests\MassDestroyAssetRequest;
use App\Stock;
use App\Transaction;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('asset_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $assets = Asset::with('category')->latest()->get();
        return view('admin.assets.index', compact('assets'));
    }

    public function create()
    {
        abort_if(Gate::denies('asset_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories=Category::get();
        return view('admin.assets.create',compact('categories'));
    }

    public function store(StoreAssetRequest $request)
    {
        $asset = Asset::create($request->all());
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            $asset->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        $stock =Stock::where('id',$asset->id)->update(['current_stock' => $request->quantity]);
        $transactionData = [
            'stock' => $request->quantity,
            'asset_id' => $asset->id,
            'team_id' => 1,
            'user_id' => 1,
        ];
        $transiction = Transaction::create($transactionData);
        return redirect()->route('admin.assets.index')->with(['success' => 'Assets Created Successfully']);
    }

    public function edit(Asset $asset)
    {
        abort_if(Gate::denies('asset_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $categories=Category::get();
        return view('admin.assets.edit', compact('asset','categories'));
    }

    public function update(UpdateAssetRequest $request, Asset $asset)
    {
        // $request;
        if($request->hasFile('avatar') && $request->file('avatar')->isValid()){
            \DB::table('media')->where('model_id',$asset['id'])->delete();
            $asset->addMediaFromRequest('avatar')->toMediaCollection('avatar');
        }
        $asset->update($request->all());
        return redirect()->route('admin.assets.index')->with(['success' => 'Assets Updated Successfully']);
    }

    public function show(Asset $asset)
    {
        abort_if(Gate::denies('asset_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.assets.show', compact('asset'));
    }

    public function destroy(Asset $asset)
    {
        abort_if(Gate::denies('asset_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $asset->delete();
        return back()->with(['success' => 'Assets Deleted Successfully']);
    }

    public function massDestroy(MassDestroyAssetRequest $request)
    {
        Asset::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function updateStatus(Request $request,$id)
    { 
        $status = Asset::where('id', $id)->first()->status;
        $status = $status ? '0' : '1';
        $AssetStatus = Asset::where('id', $id)->update([ 'status' => $status ]);
        return back()->with(['success' => 'Assets Updated Successfully']);
    }
}
