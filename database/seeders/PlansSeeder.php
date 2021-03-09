<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = array(
            array(
                'type' => 'ONETIME',
                'name' => 'Free plan',
                'price' => 0,
                'capped_amount' => 0,
                'terms' => `Free plan`,
                'terms_plan' => serialize(
                    array(
                        'Shop_limit' => 1,
                        'Max_posts' => 8,
                        'Post_update_time' => 24,
                        'Post_control' => false,
                        'Visits_Limit' => 1000,
                    )
                ),
                'trial_days' => 0,
                'test' => true,
                'on_install' => 1
            ),

            array(
                'type' => 'RECURRING',
                'name' => 'Start plan',
                'price' => 4.99,
                'capped_amount' => 4.99,
                'terms' => `Start plan`,
                'interval' => 'EVERY_30_DAYS',
                'terms_plan' => serialize(
                    array(
                        'Shop_limit' => 1,
                        'Max_posts' => 20,
                        'Post_update_time' => 4,
                        'Post_control' => true,
                        'Sections' => 'base'
                    )
                ),
                'trial_days' => 0,
                'test' => true,
                'on_install' => 0
            )
        );

        foreach ($plans as $plan) {
            DB::table('plans')
                ->insert([
                    'type' => $plan['type'],
                    'name' => $plan['name'],
                    'price' => $plan['price'],
                    'capped_amount' => $plan['capped_amount'],
                    'terms' => $plan['terms'],
                    'terms_plan' => $plan['terms_plan'],
                    'trial_days' => $plan['trial_days'],
                    'test' => $plan['test'],
                    'on_install' => $plan['on_install'],
                ]);
        }
    }
}
