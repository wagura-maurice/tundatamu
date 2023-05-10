<?php

namespace App\Http\Controllers\Mpesa;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Interfaces\Mpesa\LNMOInterface;

class LNMOController extends Controller
{
    public function transact(Request $request, LNMOInterface $LNMOInterface)
    {
        try {
            $data = array_filter([
                'Amount' => (int) $request->amount,
                'PartyA' => str_replace('+', '', phoneNumberPrefix($request->phone_number)),
                'PhoneNumber' => str_replace('+', '', phoneNumberPrefix($request->phone_number)),
                'AccountReference' => $request->order_id,
                'TransactionDesc' => strtoupper('lipa na mpesa online transaction: ' . '\n' .  ' order #; ' . $request->order_id . '\n' .  ' date; ' . Carbon::now()->format('YmdHis'))
            ]);

            return response()->json(array_filter([
                'status' => 'info',
                'message' => 'transaction initialized',
                'data' => $LNMOInterface->transact($data)
            ]), 200);

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());

            return response()->json(array_filter([
                'status' => 'danger',
                'message' => strtoupper(get_class($this) . ' ' . $th->getMessage()),
                'data' => array_filter([])
            ]), 400);
        }
    }

    public function query(Request $request, LNMOInterface $LNMOInterface)
    {
        try {
            return response()->json(array_filter([
                'status' => 'info',
                'message' => 'transaction query initialized',
                'data' => $LNMOInterface->query($request->transaction_id)
            ]), 200);

        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());

            return response()->json(array_filter([
                'status' => 'danger',
                'message' => strtoupper(get_class($this) . ' ' . $th->getMessage()),
                'data' => array_filter([])
            ]), 400);
        }
    }

    public function callback(Request $request, LNMOInterface $LNMOInterface)
    {
        try {
            return response()->json(array_filter([
                'status' => 'info',
                'message' => 'transaction callback initialized',
                'data' => $LNMOInterface->callback($request->toArray())
            ]), 200);
        } catch (\Throwable $th) {
            // throw $th;
            eThrowable(get_class($this), $th->getMessage());

            return response()->json(array_filter([
                'status' => 'danger',
                'message' => strtoupper(get_class($this) . ' ' . $th->getMessage()),
                'data' => array_filter([])
            ]), 400);
        }
    }
}
