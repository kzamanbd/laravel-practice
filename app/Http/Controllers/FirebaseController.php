<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Exception\DatabaseException;

class FirebaseController extends Controller
{
    private Database $database;

    public function __construct()
    {
        $this->database = FirebaseService::createDatabase();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws DatabaseException
     */
    function store(Request $request)
    {
        $bKash = "⁨bKash⁩";
        $nagad = "⁨NAGAD⁩";

        $androidText = $request->input('android_text');
        if (str_contains($request->input('android_title'), "bKash")) {
            $secondArray = explode("TrxID", $androidText);
            $transactionId = isset($secondArray[1]) ? explode("at", $secondArray[1])[0] : null;
        } else if (str_contains($request->input('android_title'), "NAGAD")) {
            $secondArray = explode("TxnID:", $androidText);
            $transactionId = isset($secondArray[1]) ? explode("Comm", $secondArray[1])[0] : null;
        } else {
            $transactionId = null;
        }
        $uid = now()->format("YmdHis");
        if ($transactionId != null) {
            $newArray = [
                'transaction_id' => trim($transactionId),
                'created_at' => now()->format('Y-m-d H:i:s')
            ];
            $newReference = $this->database->getReference("notifications/$uid");
            $arrayMarge = array_merge($request->all(), $newArray);
            $newReference->set($arrayMarge);
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
                    'created_at' => now()->format('Y-m-d H:i:s')
                ];
                $newNagad = $this->database->getReference("nagad_numbers/$uid");
                $newNagad->set($inputArray);
            } else {
                $newNagad = [];
            }
        }

        if (isset($newReference) or isset($newNagad)) {
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
     * @throws DatabaseException
     */
    function getNotification()
    {
        $reference = $this->database->getReference("notifications");
        $snapshot = $reference->getSnapshot();
        $collection = collect($snapshot->getValue());
        $notifications = [];
        foreach ($collection as $item) {
            $notifications[] = $item;
        }

        $nagad = $this->database->getReference("nagad_numbers");
        $nagadSnapshot = $nagad->getSnapshot();
        $nagadCollection = collect($nagadSnapshot->getValue())->whereBetween('created_at', [now()->subMinutes(1440), now()])->all();
        $nagadMessages = [];
        foreach ($nagadCollection as $item) {
            $nagadMessages[] = $item;
        }

        return response()->json([
            "status" => true,
            "message" => "Success",
            "nagad_messages" => $nagadMessages,
            "notifications" => $notifications
        ]);
    }
}
