<?php

namespace DraftScripts\FileManager\Models;


use Illuminate\Database\Eloquent\Model;

class FileManagerKey extends Model
{

    public function getPrivateKeyAttribute($value)
    {
        return decrypt($value);
    }

    public function setPrivateKeyAttribute($value)
    {
        $this->attributes['private_key'] = encrypt($value);
    }

    public function getPasswordAttribute($value)
    {
        return decrypt($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = encrypt($value);
    }
}
