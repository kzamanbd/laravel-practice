<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    //
    private $database;

    public function __construct()
    {
        $this->database = FirebaseService::createDatabase();
    }
    public function firebase(){
        $database = FirebaseService::createDatabase();
        return $database->getReference('users')->getValue();
    }
    
    function getNotification(){
        $reference = $this->database->getReference("notifications");
        $snapshot = $reference->getSnapshot();
        $collection = collect($snapshot->getValue());
        $notifications = [];
        foreach($collection as $item){
            if($item['transaction_id'] != "" OR $item['transaction_id'] != null){
                $notifications[] = $item;
            }
        }

        $nagad = $this->database->getReference("nagad_numbers");
        $nagadSnapshot = $nagad->getSnapshot();
        $nagadCollection = collect($nagadSnapshot->getValue())->whereBetween('created_at', [now()->subMinutes(1440), now()])->all();
        $nagadMessages = [];
        foreach($nagadCollection as $item){
            if($item['mobile'] != "" OR $item['mobile'] != null){
                $nagadMessages[] = $item;
            }
        }

        return response()->json([
            "message" => "Success",
            "notifications" => $notifications,
            "nagad_messages" => $nagadMessages
        ]);
    }
}
