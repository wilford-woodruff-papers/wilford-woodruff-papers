<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

/*Route::get('/subjects/{subject}', [\App\Http\Controllers\SubjectController::class, 'show'])->name('api.subjects.show');*/

Route::middleware(['auth:sanctum', 'throttle:30', \App\Http\Middleware\LogApiUsageMiddleware::class])
    ->prefix('v1')
    ->group(function () {
        Route::get('documents', [\App\Http\Controllers\Api\v1\DocumentController::class, 'index'])
            ->name('api.documents.index');
        Route::get('documents/export', [\App\Http\Controllers\Api\v1\DocumentationController::class, 'export'])
            ->name('api.documents.export');
        Route::get('documents/{item}', [\App\Http\Controllers\Api\v1\DocumentController::class, 'show'])
            ->name('api.documents.show');

        Route::get('pages', [\App\Http\Controllers\Api\v1\PageController::class, 'index'])
            ->name('api.pages.index');
        Route::get('pages/export', [\App\Http\Controllers\Api\v1\PageController::class, 'export'])
            ->name('api.pages.export');
        Route::get('pages/{page}', [\App\Http\Controllers\Api\v1\PageController::class, 'show'])
            ->name('api.pages.show');

        Route::get('subjects', [\App\Http\Controllers\Api\v1\SubjectController::class, 'index'])
            ->name('api.subjects.index');
        Route::get('subjects/{id}', [\App\Http\Controllers\Api\v1\SubjectController::class, 'show'])
            ->name('api.subjects.show');

        Route::get('people', [\App\Http\Controllers\Api\v1\PeopleController::class, 'index'])
            ->name('api.people.index');
        Route::get('people/export', [\App\Http\Controllers\Api\v1\PeopleController::class, 'export'])
            ->name('api.people.export');
        Route::get('people/{id}', [\App\Http\Controllers\Api\v1\PeopleController::class, 'show'])
            ->name('api.people.show');

        Route::get('places', [\App\Http\Controllers\Api\v1\PlacesController::class, 'index'])
            ->name('api.places.index');
        Route::get('places/export', [\App\Http\Controllers\Api\v1\PlacesController::class, 'export'])
            ->name('api.places.export');
        Route::get('places/{id}', [\App\Http\Controllers\Api\v1\PlacesController::class, 'show'])
            ->name('api.places.show');

        Route::get('topics', [\App\Http\Controllers\Api\v1\TopicsController::class, 'index'])
            ->name('api.topics.index');
        Route::get('topics/export', [\App\Http\Controllers\Api\v1\TopicsController::class, 'export'])
            ->name('api.topics.export');
        Route::get('topics/{id}', [\App\Http\Controllers\Api\v1\TopicsController::class, 'show'])
            ->name('api.topics.show');
});
