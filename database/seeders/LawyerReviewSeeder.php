<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\Models\Lawyer;
use App\Models\LawyerReview;

class LawyerReviewSeeder extends Seeder
{
    /**
     * Seed the lawyer_reviews table.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get existing lawyers and customers
        $lawyerIds = DB::table('lawyers')->pluck('id')->toArray();
        $customerIds = DB::table('customers')->pluck('id')->toArray();

        foreach ($lawyerIds as $lawyerId) {
            foreach ($customerIds as $customerId) {
                $rating = $faker->numberBetween(1, 5);
                $reviewText = $faker->sentence(30);

                $lawyer = Lawyer::find($lawyerId);
                $existingReview = LawyerReview::where('lawyer_id', $lawyerId)
                    ->where('customer_id', $customerId)
                    ->first();

                if ($existingReview) {
                    $oldRating = $existingReview->rating;
                    $existingReview->rating = $rating;
                    $existingReview->save();


                    $lawyer->updateAverageRating($rating, $oldRating);

                } else {

                    LawyerReview::create([
                        'lawyer_id' => $lawyerId,
                        'customer_id' => $customerId,
                        'rating' => $rating,
                        'review' => $reviewText,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $lawyer->updateAverageRating($rating);

                }

                // Create a review


                // Update lawyer's average rating


            }
        }
    }
}
