<?php

use Illuminate\Database\Seeder;

class settingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting')->truncate();

        DB::table('setting')->insert([
            [
                'setting'      => 'Event',
                'status'       => 0,
            ]

        ]);
    }
}
