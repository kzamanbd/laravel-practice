<?php

namespace App\Services;

use Kreait\Firebase\Contract\Database;
use Kreait\Firebase\Factory;

class FirebaseService
{

    /**
     * @return Factory
     */
    private static function createFactory(): Factory
    {
        return (new Factory)
            ->withServiceAccount(storage_path("firebase.json"))
            ->withDatabaseUri("https://fir-zaman-default-rtdb.asia-southeast1.firebasedatabase.app/");
    }

    /**
     * @return Database
     */
    public static function createDatabase(): Database
    {
        return self::createFactory()->createDatabase();
    }
}
