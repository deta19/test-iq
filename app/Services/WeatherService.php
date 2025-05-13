<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('WEATHER_KEY');
    }

    public function getLocationKey($latitude, $longitude)
    {
        $url = 'http://dataservice.accuweather.com/locations/v1/cities/geoposition/search';

        $response = Http::get($url, [
            'apikey' => $this->apiKey,
            'q' => "{$latitude},{$longitude}"
        ]);

        if ($response->successful()) {
            return $response->json()['Key'] ?? null;
        }

        return null;
    }

   
    public function getWeather($latitude, $longitude)
    {

        $locationKey = $this->getLocationKey($latitude, $longitude);

        if (!$locationKey) {
            return null;
        }

        $url = "http://dataservice.accuweather.com/currentconditions/v1/{$locationKey}";

        $response = Http::get($url, [
            'apikey' => $this->apiKey,
            'details' => true
        ]);

        if ($response->successful()) {

// dd($response->json()[0]);


            return $response->json()[0];

        }

        return null;
    }
}