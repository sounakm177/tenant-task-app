<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TaskStatus;
use App\Enums\TaskPriority;

class Task extends BaseModel
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
