<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeditationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('meditations')->insert(
            [
                [
                    'name' => 'Uykulu',
                    'time' => '00:05:00'
                ],
                [
                    'name' => 'Stresli',
                    'time' => '00:17:00'
                ],
                [
                    'name' => 'Kaygılı',
                    'time' => '01:20:00'
                ],
                [
                    'name' => 'Mutlu',
                    'time' => '01:10:00'
                ],
                [
                    'name' => 'Duygusal',
                    'time' => '00:20:00'
                ],
                [
                    'name' => 'Yorgun',
                    'time' => '00:10:00'
                ],
                [
                    'name' => 'Gergin',
                    'time' => '00:05:00'
                ],
                [
                    'name' => 'Yalnız',
                    'time' => '00:15:00'
                ],
                [
                    'name' => 'Üzgün',
                    'time' => '02:20:00'
                ],
                [
                    'name' => 'Heyecanlı',
                    'time' => '00:14:00'
                ],
                [
                    'name' => 'Öfkeli',
                    'time' => '00:11:00'
                ]
            ],
        );
    }
}
