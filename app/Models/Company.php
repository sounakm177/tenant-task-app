<?php

namespace App\Models;

use App\Models\BaseModel;

class Company extends BaseModel
{
    protected $fillable = ['name', 'status', 'plan_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
