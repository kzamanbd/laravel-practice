<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService {
    
    private static function createFactory(){
        return (new Factory)->withServiceAccount(storage_path("firebase.json"))->withDatabaseUri("https://ai-notifier-fc-default-rtdb.europe-west1.firebasedatabase.app");
    }

    public static function createDatabase(){
        return self::createFactory()->createDatabase();
    }
}
