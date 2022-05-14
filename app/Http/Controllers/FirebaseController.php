<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;
use Illuminate\Http\Request;

class FirebaseController extends Controller
{
    //

    public function firebase(){
        $database = FirebaseService::createDatabase();
        return $database->getReference('users')->getValue();
    }
}
