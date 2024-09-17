<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use Faker\Factory as faker;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::factory()->count(20000)->create();

        $faker=Faker::create();

        for($i=0;$i<5000;$i++){

            $customer=new App\Models\Customer();
            $customer->name=$faker->name;
            $customer->email=$faker->email;
            $customer->password=Hash::make(12345678);

            $customer->save();



        }

    }
}
