<?php

namespace App\Repositories;

use App\Models\Plan;
use App\Repositories\Interfaces\PlanRepositoryInterface;

final class PlanRepository extends BaseRepository implements PlanRepositoryInterface
{
    public function __construct(Plan $plan)
    {
        parent::__construct($plan);
    }
}
