<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService {
    
    private static function createFactory(){
        return (new Factory)->withServiceAccount(base_path("firebase.json"))->withDatabaseUri("https://notification-forwarder-22-default-rtdb.asia-southeast1.firebasedatabase.app");
    }

    public static function createDatabase(){
        return self::createFactory()->createDatabase();
    }
}
