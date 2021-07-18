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
                    'completed' => 'Y',
                    'created_at' => '2021-07-20 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 2,
                    'completed' => 'Y',
                    'created_at' => '2021-07-15 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 3,
                    'completed' => 'Y',
                    'created_at' => '2021-07-16 00:00:00'
                ],
                [
                    'user_id' => 2,
                    'meditation_id' => 4,
                    'completed' => 'Y',
                    'created_at' => '2021-07-17 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 5,
                    'completed' => 'Y',
                    'created_at' => '2021-07-18 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 6,
                    'completed' => 'Y',
                    'created_at' => '2021-07-19 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 7,
                    'completed' => 'Y',
                    'created_at' => '2021-07-22 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 8,
                    'completed' => 'Y',
                    'created_at' => '2021-07-23 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 9,
                    'completed' => 'Y',
                    'created_at' => '2021-07-24 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 10,
                    'completed' => 'Y',
                    'created_at' => '2021-07-25 00:00:00'
                ],
                [
                    'user_id' => 1,
                    'meditation_id' => 11,
                    'completed' => 'Y',
                    'created_at' => '2021-07-26 00:00:00'
                ]
            ]
        );
    }
}
