<?php

use Illuminate\Database\Seeder;

class voteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('voting')->delete();
        DB::table('voting')->insert([
            [
                'name'   	=> 'Alice',
                'vote'  	=> 'A',
            ],
            [
                'name'   	=> 'Bob',
                'vote'  	=> 'A',
            ],
            [
                'name'   	=> 'Clark',
                'vote'  	=> 'B',
            ],
        ]);
    }
}
