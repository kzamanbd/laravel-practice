<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService {
    
    private static function createFactory(){
        return (new Factory)->withServiceAccount(base_path("firebase.json"))->withDatabaseUri("https://fir-d846d-default-rtdb.firebaseio.com");
    }

    public static function createDatabase(){
        return self::createFactory()->createDatabase();
    }
}
