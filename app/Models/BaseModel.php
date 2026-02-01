<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notification;

abstract class BaseModel extends Model
{
	public function hasAttribute($attribute)
    {
        return array_key_exists($attribute, $this->attributes);
    }
}
