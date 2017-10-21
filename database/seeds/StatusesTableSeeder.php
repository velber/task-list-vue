<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name' => 'Status 1',
            ],
            [
                'name' => 'Status 2',
            ],
            [
                'name' => 'Status 3',
            ]
        ]);
    }
}
