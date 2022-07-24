<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\NagadNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class NotifierController extends Controller
{
    const BKASH = "BKASH";
    const NAGAD = "NAGAD";
    const ROCKET = "ROCKET";
    const UPAY = "UPAY";

    /**
     * @param Request $request
     * @return JsonResponse
     */
    function store(Request $request)
    {
        $transactionId = self::getTransactionId($request->input('android_title'), $request->input('android_text'));
        if (Message::query()->where('transaction_id', trim($transactionId))->exists()) {
            return response()->json([
                'status' => true,
                'message' => 'Already Exists',
            ]);
        }
        $message = Message::create([
            'android_title' => $request->input('android_title'),
            'android_text' => $request->input('android_text'),
            'transaction_id' => trim($transactionId),
            'msg_from' => substr($request->input('msg_from'), -11),
        ]);

        if (isset($message)) {
            return response()->json([
                'status' => true,
                'message' => 'Successfully Added',
                'detail' => $message,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Failed to add',
        ]);
    }

    function syncOfflineMessage(Request $request)
    {
        if ($request->input('messages')) {
            $offlineIds = [];
            foreach (json_decode($request->input('messages'), true) as $message) {
                $transactionId = self::getTransactionId($message['android_title'], $message['android_text']);
                if (!Message::query()->where('transaction_id', trim($transactionId))->exists()) {
                    $newMsg = Message::create([
                        'android_title' => $message['android_title'],
                        'android_text' => $message['android_text'],
                        'transaction_id' => trim($transactionId),
                        'msg_from' => substr($request->input('msg_from'), -11),
                        'is_offline' => $message['offline_id'],
                        'created_at' => Carbon::parse($message['created_at'])->format('Y-m-d H:i:s'),
                    ]);

                    $offlineIds[] = $newMsg->is_offline;
                }

            }

            $countIds = count($offlineIds);
            if ($countIds > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "$countIds Offline Message Synced",
                    'offlineIds' => $offlineIds
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Operation Failed',
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Failed to Add',
        ]);
    }

    /**
     * @param string $androidTitle
     * @param string $androidText
     * @return string|null
     */
    function getTransactionId(string $androidTitle, string $androidText)
    {
        if (Str::contains(Str::upper($androidTitle), self::BKASH) or Str::contains(Str::upper($androidTitle), self::UPAY)) {
            $secondArray = explode('TrxID ', $androidText);
            $transactionId = isset($secondArray[1]) ? substr($secondArray[1], 0, 10) : null;
        } else if (Str::contains(Str::upper($androidTitle), self::NAGAD)) {
            $secondArray = explode('TxnID: ', $androidText);
            $transactionId = isset($secondArray[1]) ? substr($secondArray[1], 0, 8) : null;
        } else if (Str::contains(Str::upper($androidTitle), self::ROCKET)) {
            $secondArray = explode('TxnId: ', $androidText);
            $transactionId = isset($secondArray[1]) ? substr($secondArray[1], 0, 10) : null;
        } else {
            $transactionId = null;
        }
        return $transactionId;
    }

    /**
     * @return JsonResponse
     */
    function getNotification()
    {
        $notifications = Message::query()
            ->whereBetween('created_at', [now()->subMinutes(2880), now()])
            ->latest()
            ->get(['id', 'android_title', 'android_text', 'transaction_id', 'created_at']);

        $countNotification = count($notifications);
        return response()->json([
            'status' => true,
            'message' => "Last 2 days total $countNotification messages Found!",
            'nagad_messages' => [],
            'notifications' => $notifications
        ]);
    }
}
