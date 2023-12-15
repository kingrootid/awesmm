<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Deposit;
use App\Models\Deposits;
use App\Models\PPOB;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Svakode\Svaflazz\Svaflazz;

class TripayCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $privateKey = config('configApp.tripay.api_private');
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, $privateKey);

        if ($signature !== (string) $callbackSignature) {
            return 'Invalid signature';
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return 'Invalid callback event, no action was taken';
        }

        $data = json_decode($json);
        $uniqueRef = $data->merchant_ref;
        $status = strtoupper((string) $data->status);

        /*
       |--------------------------------------------------------------------------
       | Proses callback untuk closed payment
       |--------------------------------------------------------------------------
       */
        if (1 === (int) $data->is_closed_payment) {
            $invoice = Deposit::where('method_ref', $uniqueRef)->first();
            if (!$invoice) return response()->json(['success' => false]);
            $newStatus = "Pending";
            if ($status == "PAID") {
                $user = User::where('id', $invoice->user_id)->first();
                $user->balance += $invoice->get;
                $user->save();
                Activity::create([
                    'user_id' => $user->id,
                    'type' => 'plus',
                    'note' => 'Deposit #' . $invoice->id . ' Berhasil',
                    'amount' => $invoice->get,
                ]);
                $newStatus = "Success";
            } else if ($status == "EXPIRED") {
                $newStatus = "Canceled";
            } else if ($status == "FAILED") {
                $newStatus = "Canceled";
            }
            $invoice->update(['status' => $newStatus, 'log_payment' => json_encode($data, TRUE)]);
            return response()->json(['success' => true]);
        }


        /*
       |--------------------------------------------------------------------------
       | Proses callback untuk open payment
       |--------------------------------------------------------------------------
       */
        $invoice = Deposit::where('method_ref', $uniqueRef)
            ->where('status', 'Pending')
            ->first();

        if (!$invoice) {
            return 'Invoice not found or current status is not UNPAID';
        }

        if ((int) $data->total_amount !== (int) $invoice->amount) {
            return 'Invalid amount, Expected: ' . $invoice->amount . ' - Received: ' . $data->total_amount;
        }

        switch ($data->status) {
            case 'PAID':
                $invoice->update(['status' => 'Success', 'log_payment' => json_encode($data, TRUE)]);
                $user = User::where('id', $invoice->user_id)->first();
                $user->balance += $invoice->amount;
                $user->save();
                Activity::create([
                    'user_id' => $user->id,
                    'type' => 'plus',
                    'note' => 'Deposit #' . $invoice->id . ' Berhasil',
                    'amount' => $invoice->get,
                ]);
                return response()->json(['success' => true]);

            case 'EXPIRED':
                $invoice->update(['status' => 'Canceled', 'log_payment' => json_encode($data, TRUE)]);
                return response()->json(['success' => true]);

            case 'FAILED':
                $invoice->update(['status' => 'Canceled', 'log_payment' => json_encode($data, TRUE)]);
                return response()->json(['success' => true]);
            default:
                return response()->json(['error' => 'Unrecognized payment status']);
        }
    }
}
