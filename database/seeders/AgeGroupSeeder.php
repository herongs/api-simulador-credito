<?php

namespace Database\Seeders;

use App\Models\AgeGroups;
use Illuminate\Database\Seeder;

class AgeGroupSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $age_groups = [
            [
                'min_age' => 0,
                'max_age' => 25,
                'annual_interest_rate' => 5.0,
            ],
            [
                'min_age' => 26,
                'max_age' => 40,
                'annual_interest_rate' => 3.0,
            ],
            [
                'min_age' => 41,
                'max_age' => 60,
                'annual_interest_rate' => 2.0,
            ],
            [
                'min_age' => 61,
                'max_age' => 100,
                'annual_interest_rate' => 4.0,
            ],
        ];

        foreach ($age_groups as $group) {
            $age_group = AgeGroups::firstOrNew(
                array(
                    'min_age' => $group['min_age'],
                    'max_age' => $group['max_age'],
                    'annual_interest_rate' => $group['annual_interest_rate'],
                ),
            );
            $age_group->save();
        }
    }
}
