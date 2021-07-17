<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserMeditationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_meditations')->insert(
            [
                [
                    'user_id' => 1,
                    'meditation_id' => 1,
                    'completed' => 'Y'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 2,
                    'completed' => 'Y'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 3,
                    'completed' => 'Y'
                ]
            ]
        );
    }
}
