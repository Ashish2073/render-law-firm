<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Lawyer;
use Faker\Factory as faker;
use DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Avneesh kumar',
        //     'email' => 'avneesh@roilift.com',
        //     'password' => bcrypt('admin123'),
        // ]);
        // $this->call([
        //     CustomerSeeder::class,
        // ]);


        $faker = Faker::create();

        // for($i=0;$i<10000;$i++){

        //     $lawyer = new Lawyer();
        //     $lawyer->name = $faker->name;
        //     $lawyer->email = $faker->unique()->safeEmail;
        //     $lawyer->phone_no = $faker->unique()->phoneNumber;
        //     $lawyer->description_bio = $faker->text;


        //     $lawyer->save();



        // }

        $uniqueCombinations = [];

        for ($i = 0; $i < 5000; $i++) {
            $lawyerId = $faker->numberBetween(1, 5000);
            $proficienceId = $faker->numberBetween(1, 8);

            // Generate a unique key for the combination
            $combinationKey = $lawyerId . '-' . $proficienceId;

            // Check if the combination already exists in the set
            while (isset($uniqueCombinations[$combinationKey])) {
                // If it exists, generate a new combination
                $lawyerId = $faker->numberBetween(1, 100);
                $proficienceId = $faker->numberBetween(1, 8);
                $combinationKey = $lawyerId . '-' . $proficienceId;
            }

            // Add the new combination to the set
            $uniqueCombinations[$combinationKey] = true;

            // Insert the record
            DB::table('lawyer_proficiencies')->insert([
                'lawyer_id' => $lawyerId,
                'proficience_id' => $proficienceId,
            ]);
        }

    }
}
