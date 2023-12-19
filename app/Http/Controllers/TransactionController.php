<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::all();
        return response()->json($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return response()->json($transaction);
    }

    public function store(Request $request)
    {
        $transaction = Transaction::create($request->all());
        return response()->json($transaction, 201);
    }

    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->update($request->all());
        return response()->json($transaction, 200);
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return response()->json(null, 204);
    }

    public function receiveItem(Request $request)
    {
        $item_id = $request->input('item_id');
        $warehouse_location_id = $request->input('warehouse_location_id');

        $transaction = Transaction::create([
            'item_id' => $item_id,
            'warehouse_location_id' => $warehouse_location_id,
            'type' => 'received',
            'quantity' => 1,
            'comment' => 'Created by API'
        ]);

        return response()->json($transaction, 201);
    }
}
