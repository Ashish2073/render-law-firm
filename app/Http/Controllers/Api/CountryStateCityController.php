<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CountryStateCityController extends Controller
{
    public function getCountry(Request $request){
        try{

            $searchTerm=$request->get('search_term');
            $country=Country::where('name', 'like', $searchTerm . '%')->orwhere('iso3', 'like', $searchTerm . '%')->select('id','name')->get();
            return response()->json(['data'=>$country]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
 

    }


    public function getState(Request $request){
        try{

            $countryId=$request->get('countryid');
            $searchTerm=$request->get('search_term');
            $states=State::where('country_id',$countryId)->where('name', 'like', $searchTerm . '%')->select('id','name')->get();
            return response()->json(['data'=>$states]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
 

    }


    public function getCity(Request $request){
        try{

            $countryId=$request->get('countryid');
            $stateId=$request->get('stateid');
            $searchTerm=$request->get('search_term');
         

         
            $cities=City::where('country_id',$countryId)->where('state_id',$stateId)->where('name', 'like', $searchTerm . '%')->select('id','name')->get();
            return response()->json(['data'=>$cities]);
        }catch(\Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
 

    }





}
