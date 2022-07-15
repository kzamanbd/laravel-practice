<?php

namespace App\Http\Controllers;

use App\Models\MessageNotifier;
use App\Models\NagadNumber;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class NotifierController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    function store(Request $request)
    {
        $androidText = $request->input('android_text');
        if (Str::contains($request->input('android_title'), "bKash")) {
            $secondArray = explode("TrxID ", $androidText);
            $transactionId = isset($secondArray[1]) ? explode(" ", $secondArray[1])[0] : null;
        } else if (Str::contains($request->input('android_title'), "NAGAD")) {
            $secondArray = explode("TxnID:", $androidText);
            $transactionId = isset($secondArray[1]) ? explode("Comm:", $secondArray[1])[0] : null;
        } else {
            $transactionId = null;
        }
        if ($transactionId != null) {
            $newArray = [
                'transaction_id' => trim($transactionId),
            ];
            $arrayMarge = array_merge($request->all(), $newArray);
            $message = MessageNotifier::create($arrayMarge);
        }
        if ($request->input('package_name') == "com.konasl.nagad" or $request->input('package_name') == "com.konasl.nagad.agent") {
            // get lest 11 digits
            $numberArray = explode(":", $androidText);
            $mobileNumber = str_replace("-", "", trim(end($numberArray)));
            if (strlen($mobileNumber) == 11) {
                $inputArray = [
                    'mobile' => $mobileNumber,
                    'android_text' => trim($androidText),
                    'android_title' => trim($request->input('android_title')),
                    'package_name' => $request->input('package_name'),
                ];
                $newNagad = NagadNumber::create($inputArray);
            }
        }

        if (isset($message) or isset($newNagad)) {
            return response()->json([
                "status" => true,
                "message" => "Successfully Added",
            ]);
        }
        return response()->json([
            "status" => false,
            "message" => "Not found!",
        ]);
    }

    /**
     * @return JsonResponse
     */
    function getNotification()
    {
        $notifications = MessageNotifier::query()
            ->whereBetween('created_at', [now()->subMinutes(4320), now()])
            ->latest()
            ->get();

        $nagadMessages = NagadNumber::query()
            ->whereBetween('created_at', [now()->subMinutes(1440), now()])
            ->get();

        $countNotification = count($notifications);
        $countNagad = count($nagadMessages);
        return response()->json([
            "status" => true,
            "message" => "Total $countNotification Notification and $countNagad Mobile Number Founds!",
            "nagad_messages" => $nagadMessages,
            "notifications" => $notifications
        ]);
    }
}
