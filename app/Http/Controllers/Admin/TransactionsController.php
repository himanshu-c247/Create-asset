<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Asset;
use App\Stock;
use Exception;
use App\Category;
use App\Transaction;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Requests\StoreTransactionRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateTransactionRequest;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Http\Requests\MassDestroyTransactionRequest;
use App\Team;

/**
 * Class TransactionsController
 * @package App\Http\Controllers\Admin
 */
class TransactionsController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $search = $request['search'];
        $category = $request['category'];
        $team = $request['team'];
        $categories= Category::get();
        $teams = Team::get();
        $transactions = Transaction::with('asset','user','team');
        if ($request['search']) 
        {
            $transactions = $transactions->with([ 'asset' => function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            },])->whereHas('asset', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })->with([ 'user' => function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            }])->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
        if ($request['category']) 
        {
            $transactions = $transactions->with([ 'asset.category' => function ($q) use ($category) {
                $q->where('id',$category);
            },])->whereHas('asset.category', function ($q) use ($category) {
                $q->where('id',$category);
            });
        }
        if ($request['team']) 
        {
            $transactions = $transactions->with([ 'team' => function ($q) use ($team) {
                $q->where('id',$team);
            },])->whereHas('team', function ($q) use ($team) {
                $q->where('id',$team);
            });
        }
         $transactions = $transactions->orderBy('id', 'DESC')->paginate(config('app.paginate')); 
        if ($request->ajax()) {
            $transactionSearch = view('admin.transactions.transactiontable', compact('transactions'))->render();
            return response()->json(['transactionSearch' => $transactionSearch]);
        }
        return view('admin.transactions.index', compact('transactions','categories','teams'));
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        abort_if(Gate::denies('transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.transactions.create', compact('assets', 'users'));
    }

    /**
     * @param StoreTransactionRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTransactionRequest $request)
    {
        $transaction = Transaction::create($request->all());

        return redirect()->route('admin.transactions.index');

    }

    /**
     * @param Transaction $transaction
     * @return Factory|View
     */
    public function edit(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assets = Asset::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $transaction->load('asset', 'team', 'user');

        return view('admin.transactions.edit', compact('assets', 'users', 'transaction'));
    }

    /**
     * @param UpdateTransactionRequest $request
     * @param Transaction $transaction
     * @return RedirectResponse
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return redirect()->route('admin.transactions.index');

    }

    /**
     * @param Transaction $transaction
     * @return Factory|View
     */
    public function show(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->load('asset', 'team', 'user');

        return view('admin.transactions.show', compact('transaction'));
    }

    /**
     * @param Transaction $transaction
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Transaction $transaction)
    {
        abort_if(Gate::denies('transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $transaction->delete();

        return back();

    }

    /**
     * @param MassDestroyTransactionRequest $request
     * @return ResponseFactory|\Illuminate\Http\Response
     */
    public function massDestroy(MassDestroyTransactionRequest $request)
    {
        Transaction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }

    /**
     * @param Stock $stock
     * @return RedirectResponse
     */
    public function storeStock(Stock $stock)
    {
        $action      = request()->input('action', 'add') == 'add' ? 'add' : 'remove';
        $stockAmount = request()->input('stock', 1);
        $sign        = $action == 'add' ? '+' : '-';

        if ($stockAmount < 1) {
            return redirect()->route('admin.stocks.index')->with(['error' => 'No item was added/removed. Amount must be greater than 1.']);
        }

        Transaction::create([
            'stock'    => $sign . $stockAmount,
            'asset_id' => $stock->asset->id,
            'team_id'  => $stock->team->id,
            'user_id'  => auth()->user()->id,
        ]);

        if ($action == 'add') {
            $stock->increment('current_stock', $stockAmount);
            $status = $stockAmount .' items was added to stock.';
        }
        if ($action == 'remove') {
            if ($stock->current_stock - $stockAmount < 0) {
                return response()->route('admin.stocks.index')->with(['error' => 'Not enough items in stock.',]);
            }

            $stock->decrement('current_stock', $stockAmount);
            $status = $stockAmount . ' items was removed from stock.';
            return response()->json(['status' => 'success', 'message' => $status]);
        }
        return redirect()->route('admin.stocks.index')->with(['success' => $status]);
    }
}
