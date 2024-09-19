<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CountryStateCityController extends Controller
{
    public function countrylist(Request $request)
    {
        return $this->getPaginatedList(Country::query(), $request);
    }

    public function statelist(Request $request)
    {

        return $this->getPaginatedList(State::query()->where('country_id', $request->parent_id), $request);
    }

    public function citylist(Request $request)
    {

        return $this->getPaginatedList(City::query()->where('state_id', $request->parent_id), $request);
    }

    private function getPaginatedList($query, Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        $results = $query->paginate(10, ['*'], 'page', $page);

        $data = $results->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        });

        return response()->json([
            'results' => $data,
            'hasMore' => $results->hasMorePages()
        ]);
    }


    public function getZipcodeInfo(Request $request)
    {
        $zipcode = $request->input('zipcode');


        $client = new Client();


        $data = [
            'query' => [
                'zip_code' => $zipcode,
                'country_code' => 'US'
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'apikey' => env('API_ADDRESS_KEY')
            ]
        ];



        try {
            $response = $client->request('GET', 'https://api.worldpostallocations.com/v1/search', $data);


            $responseBody = json_decode($response->getBody(), true);

            $countryCode = $responseBody['result'][0]['country'];
            $stateName = $responseBody['result'][0]['state'];
            $cityName = $responseBody['result'][0]['postalLocation'];

            $state = State::where('name', $stateName)->first();

            $city = City::where('name', $cityName)->first();

            $responseBody['result'][0]['state_id'] = $state->id;
            $responseBody['result'][0]['city_id'] = $city->id;




            return response()->json($responseBody);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Could not retrieve data'], 500);
        }
    }


}