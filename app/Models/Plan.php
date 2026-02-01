<?php

namespace App\Models;

use App\Models\BaseModel;

class Plan extends BaseModel
{
    protected $fillable = ['name', 'task_limit'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function hasUnlimitedTasks(): bool
    {
        return is_null($this->task_limit);
    }
}
