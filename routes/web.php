<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', \App\Http\Controllers\SearchController::class)->name('search');
Route::get('/documents', [\App\Http\Controllers\ItemController::class, 'index'])->name('documents');
Route::get('/documents/{item}', [\App\Http\Controllers\ItemController::class, 'show'])->name('documents.show');
Route::get('/documents/{item}/page/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/subjects/{subject}', [\App\Http\Controllers\SubjectController::class, 'show'])->name('subjects.show');
Route::get('/people', [\App\Http\Controllers\PeopleController::class, 'index'])->name('people');
Route::get('/places', [\App\Http\Controllers\PlaceController::class, 'index'])->name('places');
Route::get('/timeline', [\App\Http\Controllers\TimelineController::class, 'index'])->name('timeline');
Route::get('/donate-online', [\App\Http\Controllers\DonationController::class, 'online'])->name('donate.online');
Route::get('/donation-questions', [\App\Http\Controllers\DonationController::class, 'questions'])->name('donate.questions');
Route::get('/volunteer', [\App\Http\Controllers\GetInvolvedController::class, 'volunteer'])->name('volunteer');
Route::get('/contribute-documents', [\App\Http\Controllers\GetInvolvedController::class, 'contribute'])->name('contribute-documents');
Route::get('/about', [\App\Http\Controllers\AboutController::class, 'mission'])->name('about');
Route::get('/about/meet-the-team', [\App\Http\Controllers\AboutController::class, 'meetTheTeam'])->name('about.meet-the-team');
Route::get('/about/editorial-method', [\App\Http\Controllers\AboutController::class, 'editorialMethod'])->name('about.editorial-method');

Route::get('/media/photos', [\App\Http\Controllers\MediaController::class, 'photos'])->name('media.photos');
Route::get('/media/photos/{photo}', [\App\Http\Controllers\MediaController::class, 'photo'])->name('media.photos.show');
Route::get('/media/podcasts', [\App\Http\Controllers\MediaController::class, 'podcasts'])->name('media.podcasts');
Route::get('/media/videos', [\App\Http\Controllers\MediaController::class, 'videos'])->name('media.videos');
Route::get('/media/media-kit', [\App\Http\Controllers\MediaController::class, 'kit'])->name('media.kit');
Route::get('/media/requests', [\App\Http\Controllers\MediaController::class, 'requests'])->name('media.requests');
Route::get('/media/newsroom', [\App\Http\Controllers\MediaController::class, 'newsroom'])->name('media.news');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::get('/s/wilford-woodruff-papers/documents', function (){
    return redirect()->route('documents');
});
Route::get('/s/wilford-woodruff-papers/page/people', function (){
    return redirect()->route('people');
});
Route::get('/s/wilford-woodruff-papers/page/places', function (){
    return redirect()->route('places');
});
Route::get('/s/wilford-woodruff-papers/page/timeline', function (){
    return redirect()->route('timeline');
});
Route::get('/s/wilford-woodruff-papers/page/meet-the-team', function (){
    return redirect()->route('team');
});
Route::get('/s/wilford-woodruff-papers/page/donate-online', function (){
    return redirect()->route('donate.online');
});
Route::get('/s/wilford-woodruff-papers/page/donation-questions', function (){
    return redirect()->route('donate.questions');
});
Route::get('/s/wilford-woodruff-papers/page/volunteer', function (){
    return redirect()->route('volunteer');
});
Route::get('/s/wilford-woodruff-papers/page/contribute-documents', function (){
    return redirect()->route('contribute-documents');
});
Route::get('/s/wilford-woodruff-papers/page/about', function (){
    return redirect()->route('about');
});
Route::get('/s/wilford-woodruff-papers/page/meet-the-team', function (){
    return redirect()->route('about.meet-the-team');
});
Route::get('/s/wilford-woodruff-papers/page/editorial-method', function (){
    return redirect()->route('about.editorial-method');
});
Route::get('/s/wilford-woodruff-papers/page/newsroom', function (){
    return redirect()->route('media.news');
});
Route::get('/s/wilford-woodruff-papers/page/media-requests', function (){
    return redirect()->route('media.requests');
});
Route::get('/s/wilford-woodruff-papers/page/media-kit', function (){
    return redirect()->route('media.kit');
});
Route::get('/s/wilford-woodruff-papers/page/videos', function (){
    return redirect()->route('media.videos');
});
Route::get('/s/wilford-woodruff-papers/page/podcasts', function (){
    return redirect()->route('media.podcasts');
});
Route::get('/s/wilford-woodruff-papers/photos', function (){
    return redirect()->route('media.photos');
});
Route::get('/s/wilford-woodruff-papers/media', function (){
    return redirect()->route('search');
});
Route::get('/s/wilford-woodruff-papers/item/search', function (){
    return redirect()->route('search');
});
