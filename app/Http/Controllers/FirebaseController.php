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

        return response()->json([
            "message" => "Notification received",
            "notifications" => $notifications,
        ]);
    }
}
