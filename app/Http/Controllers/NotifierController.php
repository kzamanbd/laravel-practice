<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class NotifierController extends Controller
{
    const BKASH = "BKASH";
    const NAGAD = "NAGAD";
    const ROCKET = "16216";
    const UPAY = "UPAY";

    /**
     * @param Request $request
     * @return JsonResponse
     */
    function store(Request $request)
    {
        $androidTitle = $request->input('android_title');
        $androidText = preg_replace('/(\v|\s)+/', ' ', $request->input('android_text'));
        $transactionId = self::getTransactionId($androidTitle, $androidText);

        if (Message::query()->where('transaction_id', $transactionId)->exists()) {
            return response()->json([
                'status' => false,
                'message' => 'Already Exists',
                'app_id' => $request->input('app_id'),
            ]);
        }
        $amount = self::getAmountFromText($androidText);
        $sender = self::getSenderNumber($androidText);
        $message = Message::create([
            'android_title' => $androidTitle,
            'transaction_id' => $transactionId,
            'android_text' => $androidText,
            'amount' => $amount,
            'app_id' => $request->input('app_id'),
            'msg_from' => substr($request->input('msg_from'), -11),
            'sender' => $sender
        ]);

        if (isset($message)) {
            return response()->json([
                'status' => true,
                'message' => 'Successfully Added',
                'app_id' => $message->app_id,
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Failed to add',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    function syncOfflineMessage(Request $request)
    {
        if ($request->input('messages')) {
            $offlineIds = [];
            $transactionIds = [];
            foreach (json_decode($request->input('messages'), true) as $message) {
                $androidTitle = $message['android_title'];
                $androidText = preg_replace('/(\v|\s)+/', ' ', $message['android_text']);
                $transactionId = self::getTransactionId($androidTitle, $androidText);

                if (!Message::query()->where('transaction_id', $transactionId)->exists()) {
                    $amount = self::getAmountFromText($androidText);
                    $sender = self::getSenderNumber($androidText);
                    $newMsg = Message::create([
                        'android_title' => $androidTitle,
                        'transaction_id' => $transactionId,
                        'android_text' => $androidText,
                        'amount' => $amount,
                        'msg_from' => substr($request->input('msg_from'), -11),
                        'sender' => $sender,
                        'is_offline' => $message['offline_id'],
                        'created_at' => Carbon::parse($message['created_at'])->format('Y-m-d H:i:s'),
                    ]);

                    $offlineIds[] = $newMsg->is_offline;
                } else {
                    $offlineIdsNotSynced[] = $message['offline_id'];
                    $transactionIds[] = $transactionId;
                }
            }

            $countIds = count($offlineIds);
            if ($countIds > 0) {
                return response()->json([
                    'status' => true,
                    'message' => "$countIds Offline Message Synced",
                    'offlineIds' => $offlineIds
                ]);
            } else {
                if (count($transactionIds) > 0) {
                    return response()->json([
                        'status' => false,
                        'message' => count($transactionIds) . " Transaction ID Which Is " . collect($transactionIds)->join(', ') . 'Already Exists',
                        'offlineIds' => $offlineIdsNotSynced
                    ]);
                }
                return response()->json([
                    'status' => false,
                    'message' => 'Operation Failed',
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => 'Failed to Add',
        ]);
    }

    /**
     * @return JsonResponse
     */
    function updateSenderNumber()
    {
        $messages = Message::query()->orderByDesc('id')->get();
        $numbers = [];
        $numberNotFound = [];
        foreach ($messages as $message) {
            $senderNumber = self::getSenderNumber($message->android_text);
            if ($senderNumber) {
                $numbers[] = [
                    'id' => $message->id,
                    'number' => $senderNumber
                ];
            } else {
                $numberNotFound[] = $message->android_text;
            }
        }

        $updatedNumber = [];
        foreach ($numbers as $number) {
            $message = Message::find($number['id']);
            $message->sender = $number['number'];
            $message->save();
            $updatedNumber[] = $message->sender;
        }

        return response()->json([
            'status' => true,
            'numbers' => $updatedNumber,
            'numberNotFound' => $numberNotFound
        ]);
    }

    /**
     * @param string $androidTitle
     * @param string $text
     * @return string|null
     */
    function getTransactionId(string $androidTitle, string $text)
    {
        $androidText = trim(preg_replace('/(\v|\s)+/', ' ', $text));
        if (Str::contains(Str::upper($androidTitle), self::BKASH) or Str::contains(Str::upper($androidTitle), self::UPAY)) {
            $secondArray = explode('TrxID ', $androidText);
            $transactionId = isset($secondArray[1]) ? substr($secondArray[1], 0, 10) : null;
        } else if (Str::contains(Str::upper($androidTitle), self::NAGAD)) {
            $secondArray = explode('TxnID: ', $androidText);
            $transactionId = isset($secondArray[1]) ? substr($secondArray[1], 0, 8) : null;
        } else if (Str::contains(Str::upper($androidTitle), self::ROCKET)) {
            $secondArray = explode('TxnId:', $androidText);
            $transactionId = isset($secondArray[1]) ? substr(trim($secondArray[1]), 0, 10) : null;
        } else {
            $transactionId = null;
        }
        return trim($transactionId);
    }

    /**
     * @param string $text
     * @return int|null
     */
    function getAmountFromText(string $text)
    {
        $message = explode('Tk ', $text);
        if (isset($message[1])) {
            $amount = str_replace(',', '', explode(' ', $message[1])[0]);
            return (int)$amount;
        } else {
            return null;
        }
    }

    /**
     * @param string $text
     * @return string|null
     */
    function getSenderNumber(string $text)
    {
        $first = explode('Customer:', $text);
        if (isset($first[1])) {
            $senderNumber = substr(trim($first[1]), 0, 11);
        } else {
            $second = explode('to A/C:', $text);
            if (isset($second[1])) {
                $senderNumber = substr(trim($second[1]), 0, 11);
            } else {
                $third = explode('from A/C:', $text);
                if (isset($third[1])) {
                    $senderNumber = substr(trim($third[1]), 0, 11);
                } else {
                    $fourth = explode('Receiver:', $text);
                    if (isset($fourth[1])) {
                        $senderNumber = substr(trim($fourth[1]), 0, 11);
                    } else {
                        $fifth = explode('Sender:', $text);
                        if (isset($fifth[1])) {
                            $senderNumber = substr(trim($fifth[1]), 0, 11);
                        } else {
                            $sixth = explode('from', $text);
                            if (isset($sixth[1])) {
                                $senderNumber = substr(trim($sixth[1]), 0, 11);
                            } else {
                                $seventh = explode('to', $text);
                                if (isset($seventh[1])) {
                                    $senderNumber = substr(trim($seventh[1]), 0, 11);
                                } else {
                                    $senderNumber = null;
                                }
                            }
                        }
                    }
                }
            }
        }
        if (preg_match('/^[0-9]*$/', trim($senderNumber))) {
            return $senderNumber;
        } else {
            return null;
        }
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
            'notifications' => $notifications
        ]);
    }
}
