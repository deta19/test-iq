<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomepageController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
use App\Services\WeatherService;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomepageController::class, 'index'])->name("homepage");

Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified', 'log.headers'])->name('dashboard');

Route::get('/dashboard/users', function () {
    if (  Auth::user()->role !== 'admin' && Auth::user()->role !== 'editor' ) {
        return redirect('/dashboard');

    }
    
    return view('users');


})->middleware(['auth', 'verified', 'log.headers'])->name('users');

Route::middleware('auth', 'log.headers')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/weather/{lat}/{lon}', function ($lat, $lon, WeatherService $weatherService) {


    $weather = $weatherService->getWeather($lat, $lon);

    if (!$weather) {
        return response()->json(['error' => 'Unable to fetch weather data'], 400);
    }

    if ($weather['WeatherIcon'] < 10) {
        $weather['WeatherIcon'] = '0'.$weather['WeatherIcon'];
    }

    return response()->json([
        'temperature' => $weather['Temperature']['Metric']['Value'],
        'weather_text' => $weather['WeatherText'],
        'icon' =>  'https://developer.accuweather.com/sites/default/files/'.$weather['WeatherIcon'].'-s.png'
    ]);
});

require __DIR__.'/auth.php';