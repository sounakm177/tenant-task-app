<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Carbon;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name'       => 'Free',
                'code'       => 'free',
                'task_limit' => 5,
            ],
            [
                'name'       => 'Pro',
                'code'       => 'pro',
                'task_limit' => null,
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['code' => $plan['code']],
                [
                    'name'       => $plan['name'],
                    'task_limit' => $plan['task_limit'],
                ]
            );
        }
    }
}
