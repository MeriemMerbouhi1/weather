<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function index()
    {
        return view('weather');
    }

    public function getWeather(Request $request)
{
    $city = $request->input('city');
    $apiKey = config('services.openweathermap.key');


    try {
        $response = Http::get("http://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric',
        ]);

        $data = $response->json();

        if (isset($data['name'])) {
            return view('weather', compact('data'));
        } else {
            // Log or display the API response for debugging
            if ($response->status() == 401) {
                return view('weather')->with('error', 'Invalid API key. Please contact support for assistance.');
            } else {
                dd($data);
                return view('weather')->with('error', 'Invalid city or no weather data available for the provided city.');
            }
        }
    } catch (\Exception $e) {
        return view('weather')->with('error', 'Failed to fetch weather data. ' . $e->getMessage());
    }
}


}
