<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lawyer;
use App\Models\LawyerReview;
use App\Models\LawyerProficiencie;
use App\Models\Proficience;
use App\Models\Bookmark;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class LawyerController extends Controller
{



   

    public function getLawyerDetailList(Request $request)
    {
        try {
            $customer = $request->get('customer_id');
            $perPage = $request->input('per_page', 10);


            $lawyers = Lawyer::with(['proficiencies', 'socialmedia'])
                ->withCount([
                    'bookmarks as bookmark_status' => function ($query) use ($customer) {
                        $query->where('customer_id', $customer);
                    }
                ])->where('status','=',"1")
                ->orderBy('avg_rating', 'desc')
                ->paginate($perPage);


            $lawyers->transform(function ($lawyer)use($customer)  {
                $proficiences = $lawyer->proficiencies->map(function ($proficiency) {
                    return [
                        'id' => $proficiency->id,
                        'name' => $proficiency->proficience_name,
                        'parent_name' => $proficiency->parent_id
                            ? Proficience::find($proficiency->parent_id)->proficience_name
                            : [],
                    ];
                });


                $lawyer->proficiences_name = $proficiences->pluck('name')->toArray();
                $lawyer->proficience_parent_name = $proficiences->pluck('parent_name')->filter()->unique()->values()->toArray();
                $lawyer->socialmediadetail = $lawyer->socialmedia->pluck('social_media_url', 'social_media_id')->toArray();

                $lawyer->proficienciesId = $proficiences->pluck('id')->toArray();
                $bookmark = $lawyer->bookmarks()->where('customer_id', $customer)->first();
                $lawyer->bookmarks_id = $bookmark ? $bookmark->id :0;

                unset($lawyer->proficiencies);
                unset($lawyer->socialmedia);

                return $lawyer;
            });

            return response()->json([
                'data' => $lawyers->items(),
                'current_page' => $lawyers->currentPage(),
                'last_page' => $lawyers->lastPage(),
                'per_page' => $lawyers->perPage(),
                'total' => $lawyers->total(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function getLawyerReviewList(Request $request, $id = null)
    {
        try {

            $perPage = $request->input('per_page', 10);
            $lawyers = LawyerReview::join('customers', 'lawyer_ratings.customer_id', '=', 'customers.id')
                ->select(
                    'customers.name as cuatomer_name',
                    'lawyer_ratings.rating as lawyer_rating',
                    'lawyer_ratings.review as customer_review'
                )
                ->where('lawyer_id', $request->id)
                ->paginate($perPage);

            return response()->json($lawyers);


        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);

        }


    }


    public function lawyerReviewSave(Request $request)
    {
        try {

            DB::beginTransaction();
            $validator = Validator::make($request->all(), [
                'lawyer_id' => 'required',
                'customer_id' => 'required',
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $lawyer = Lawyer::findOrFail($request->lawyer_id);
            $existingRating = LawyerReview::where('lawyer_id', $request->lawyer_id)->where('customer_id', $request->customer_id)->first();

            if ($existingRating) {
                DB::commit();
                $oldRating = $existingRating->rating;
                $existingRating->rating = $request->rating;
                $existingRating->save();


                $lawyer->updateAverageRating($request->rating, $oldRating);

                return response()->json([
                    'status' => true,
                    'message' => 'Thank for given review',

                ], 200);


            } else {
                DB::commit();

                $lawyerReviewSave = LawyerReview::create([
                    'lawyer_id' => $request->lawyer_id,
                    'customer_id' => $request->customer_id,
                    'rating' => $request->rating,
                    'review' => $request->review

                ]);

                $lawyer->updateAverageRating($request->rating);

                return response()->json([
                    'status' => true,
                    'message' => 'Thank for given review',

                ], 200);


            }


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);

        }

    }




   

    public function lawyerSearchList(Request $request)
    {
        try {
            $searchTerm = $request->get('search_term');
            $proficiencyIds = json_decode($request->get('proficience_id'), true);
            $ratingRange = json_decode($request->get('rating_range'), true);
            $customerId = $request->get('customer_id');
            $perPage = $request->input('per_page', 10);


            $lawyersQuery = Lawyer::with(['proficiencies', 'socialmedia'])
                ->withCount([
                    'bookmarks as bookmark_status' => function ($query) use ($customerId) {
                        $query->where('customer_id', $customerId);
                    }
                ])->where('status','=',"1")
                ->orderBy('avg_rating', 'desc');

            // Apply search term filter


            if (!empty($searchTerm)) {
                $lawyersQuery->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', $searchTerm . '%')
                        ->orWhereHas('proficiencies', function ($query) use ($searchTerm) {
                            $query->where('proficience_name', 'like', $searchTerm . '%');
                        });
                });
            }


            if (!empty($proficiencyIds)) {
                $lawyersQuery->whereHas('proficiencies', function ($query) use ($proficiencyIds) {
                    $query->whereIn('proficiencies.id', $proficiencyIds);
                });
            }


            if (!empty($ratingRange)) {
                $lawyersQuery->whereBetween('avg_rating', $ratingRange);
            }


            $lawyers = $lawyersQuery->paginate($perPage);


           


            $lawyers->getCollection()->transform(function ($lawyer) use($customerId) {
                $proficiencies = $lawyer->proficiencies->map(function ($proficiency) {
                    return [
                        'id' => $proficiency->id,
                        'name' => $proficiency->proficience_name,
                        'parent_name' => $proficiency->parent_id
                            ? Proficience::find($proficiency->parent_id)->proficience_name
                            : null,
                    ];
                });

                $lawyer->proficiences_name = $proficiencies->pluck('name')->toArray();
                $lawyer->proficiencieid = $proficiencies->pluck('id')->toArray();
                $lawyer->proficience_parent_name = $proficiencies->pluck('parent_name')->filter()->unique()->values()->toArray();
                $lawyer->socialmediadetail = $lawyer->socialmedia->pluck('social_media_url', 'social_media_id')->toArray();

                $bookmark = $lawyer->bookmarks()->where('customer_id', $customerId)->first();
                $lawyer->bookmarks_id = $bookmark ? $bookmark->id :0;

                unset($lawyer->proficiencies);
                unset($lawyer->socialmedia);

                return $lawyer;
            });

            // Return the response
            return response()->json([
                'data' => $lawyers->items(),
                'current_page' => $lawyers->currentPage(),
                'last_page' => $lawyers->lastPage(),
                'per_page' => $lawyers->perPage(),
                'total' => $lawyers->total()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function legalProficienciesList(Request $request)
    {
        try {

            $parent=$request->get('parent_id');

            $proficience = Proficience::select('id', 'proficience_name')->where('parent_id', $parent)->get();

            return response()->json([
                'status' => true,
                'lawyers' => $proficience
            ], 200);




        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);


        }
    }


    public function getLawyerSuggestions(Request $request)
    {
        $searchTerm = $request->get('serach_term');

        $suggestions = Lawyer::where('name', 'like', $searchTerm . '%')
            ->select('name', 'id', DB::raw('COALESCE(lawyers.profile_image, "") as profile_image'))
            ->limit(5) // Limiting the number of suggestions
            ->get();

        return response()->json([
            'data'=>$suggestions
        ]);
    }



    public function getLawyerDetailsById(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'lawyer_id' => 'required|exists:lawyers,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $lawyerId = $request->get('lawyer_id');
            $customerId=$request->get('customer_id');

            $lawyer = Lawyer::with(['proficiencies', 'socialmedia'])->withCount([
                'bookmarks as bookmark_status' => function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId);
                }
            ])->with([
                'bookmarks' => function ($query) use ($customerId) {
                    $query->where('customer_id', $customerId)->select('id', 'lawyer_id', 'customer_id');
                }
            ])->where('id', $lawyerId)->get();

            $lawyer->map(function ($lawyer) {
                $lawyer->bookmark_id = $lawyer->bookmarks->first()->id ?? null;
                return $lawyer;});

              

            return response()->json(
                $lawyer[0]
            );



        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);


        }

    }




    public function getLawyerDetailsBasesdOnProficience(Request $request){

    }



  

}