<?php

use Illuminate\Database\Seeder;

class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
	    for($i = 0; $i < 500; $i++) {
	    	$extend = 00;
	        App\Transaction::create([
	            'user_id' 	=> floor(rand(001, 500)),
	            'name' 		=> $faker->text($maxNbChars = 10),
	            'amount' 	=> floor(rand(100, 900)).$extend,
	            'ref' 		=> 'DLA-'.rand(000,999).rand(000,999)
	        ]);
	    }
    }
}
