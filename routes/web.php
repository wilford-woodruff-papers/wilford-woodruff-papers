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

Route::domain('{year}.'.config('app.url'))->group(function () {
    Route::get('/', function ($subdomain) {
        if ($subdomain == '2023') {
            return redirect()->away(config('app.url').'/conference/2023-building-latter-day-faith');
        } elseif ($subdomain == 'book') {
            return redirect()->away(config('app.url').'/wilford-woodruffs-witness');
        } elseif ($subdomain == 'arts') {
            return redirect()->away(config('app.url').'/announcements/2023-building-latter-day-faith-conference-arts-contest-rules');
        } else {
            return redirect()->to(config('app.url'));
        }
    });
});

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
})->name('language.locale');

Route::get('/donate', [\App\Http\Controllers\DonationController::class, 'index'])->name('donate');
Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
Route::get('/advanced-search', \App\Http\Controllers\SearchController::class)->name('advanced-search');
// Route::get('/documents', [\App\Http\Controllers\ItemController::class, 'index'])->name('documents');
Route::get('/documents', \App\Http\Livewire\Documents\Browse::class)->name('documents');
Route::get('/cktest', \App\Http\Livewire\Documents\Browse::class)->name('documents.cktest');
Route::get('/dates/{year?}/{month?}', [\App\Http\Controllers\ItemController::class, 'dates'])->name('documents.dates');
Route::get('/documents/{item}', \App\Http\Livewire\Documents\Show::class)->name('documents.show');
//Route::get('/documents/{item}', [\App\Http\Controllers\ItemController::class, 'show'])->name('documents.show');
Route::get('/documents/{item}/transcript', [\App\Http\Controllers\ItemController::class, 'transcript'])->name('documents.show.transcript');
Route::get('/documents/{item}/page/{page}', [\App\Http\Controllers\PageController::class, 'show'])->name('pages.show');
Route::get('/d/{hashid}', [\App\Http\Controllers\ShortUrlController::class, 'item'])->name('short-url.item');
Route::get('/p/{hashid}', [\App\Http\Controllers\ShortUrlController::class, 'page'])->name('short-url.page');

Route::view('/wilford-woodruffs-witness', 'public.book.product-page')->name('book.product-page');
//Route::view('/wilford-woodruffs-witness-test', 'public.book.test')->name('book.product-page-test');

Route::get('/subjects/{subject}', [\App\Http\Controllers\SubjectController::class, 'show'])->name('subjects.show')
        ->missing(function (Illuminate\Http\Request $request) {
            return \Illuminate\Support\Facades\Redirect::route('home');
        });
Route::get('/people', [\App\Http\Controllers\PeopleController::class, 'index'])->name('people');
Route::get('/wives-and-children', [\App\Http\Controllers\PeopleController::class, 'family'])->name('wives-and-children');
Route::get('/places', [\App\Http\Controllers\PlaceController::class, 'index'])->name('places');
Route::get('/topics', [\App\Http\Controllers\TopicController::class, 'index'])->name('topics');
Route::get('/timeline', [\App\Http\Controllers\TimelineController::class, 'index'])->name('timeline');
Route::get('/miraculously-preserved-life', \App\Http\Controllers\MiraculouslyPreservedLife::class)->name('miraculously-preserved-life');
Route::get('/donate/online', [\App\Http\Controllers\DonationController::class, 'online'])->name('donate.online');
Route::get('/donation-questions', [\App\Http\Controllers\DonationController::class, 'questions'])->name('donate.questions');
Route::get('/get-involved', [\App\Http\Controllers\GetInvolvedController::class, 'index'])->name('get-involved.index');
Route::get('/volunteer', [\App\Http\Controllers\GetInvolvedController::class, 'volunteer'])->name('volunteer');
Route::get('/contribute-documents', [\App\Http\Controllers\GetInvolvedController::class, 'contribute'])->name('contribute-documents');
Route::get('/work-with-us', [\App\Http\Controllers\GetInvolvedController::class, 'workWithUs'])->name('work-with-us');
Route::get('/work-with-us/{opportunity}', [\App\Http\Controllers\GetInvolvedController::class, 'jobOpportunity'])->name('work-with-us.opportunity');
Route::get('/about', [\App\Http\Controllers\AboutController::class, 'mission'])->name('about');
Route::get('/about/meet-the-team', [\App\Http\Controllers\AboutController::class, 'meetTheTeam'])->name('about.meet-the-team');
Route::get('/about/partners', [\App\Http\Controllers\ParterController::class, 'index'])->name('about.partners');
Route::get('/about/editorial-method', [\App\Http\Controllers\AboutController::class, 'editorialMethod'])->name('about.editorial-method');
Route::get('/about/frequently-asked-questions', [\App\Http\Controllers\AboutController::class, 'faqs'])->name('about.frequently-asked-questions');
Route::get('/contact-us', [\App\Http\Controllers\AboutController::class, 'contact'])->name('contact-us');
Route::get('/sitemap.xml', \App\Http\Controllers\SitemapController::class)->name('sitemap');

if (app()->environment(['development', 'local'])) {
    Route::get('/search', [\App\Http\Controllers\LandingAreasController::class, 'search'])->name('landing-areas.search');
}
Route::get('/ponder', [\App\Http\Controllers\LandingAreasController::class, 'ponder'])->name('landing-areas.ponder');
Route::get('/ponder/{press?}', [\App\Http\Controllers\LandingAreasController::class, 'ponder'])->name('landing-areas.ponder.press');
Route::get('/serve', [\App\Http\Controllers\LandingAreasController::class, 'serve'])->name('landing-areas.serve');
Route::get('/testify', [\App\Http\Controllers\LandingAreasController::class, 'testify'])->name('landing-areas.testify');
Route::get('/testimonies', \App\Http\Livewire\Testimonials::class)->name('testimonies.index');

Route::get('/media/articles', [\App\Http\Controllers\MediaController::class, 'articles'])->name('media.articles');
Route::get('/media/articles/{article}', [\App\Http\Controllers\MediaController::class, 'article'])->name('media.article');
Route::get('/media/photos', [\App\Http\Controllers\MediaController::class, 'photos'])->name('media.photos');
Route::get('/media/photos/{photo}', [\App\Http\Controllers\MediaController::class, 'photo'])->name('media.photos.show');
Route::get('/media/podcasts', [\App\Http\Controllers\MediaController::class, 'podcasts'])->name('media.podcasts');
Route::get('/media/podcasts/{podcast}', [\App\Http\Controllers\MediaController::class, 'podcast'])->name('media.podcast');
Route::get('/media/videos', [\App\Http\Controllers\MediaController::class, 'videos'])->name('media.videos');
Route::get('/media/videos/{video}', [\App\Http\Controllers\MediaController::class, 'video'])->name('media.video');
Route::get('/media/media-kit', [\App\Http\Controllers\MediaController::class, 'kit'])->name('media.kit');
Route::get('/media/requests', [\App\Http\Controllers\MediaController::class, 'requests'])->name('media.requests');
Route::get('/media/newsroom', [\App\Http\Controllers\MediaController::class, 'newsroom'])->name('media.news');

Route::get('/updates', [\App\Http\Controllers\UpdateController::class, 'index'])->name('updates.index');
Route::get('/updates/{update}', [\App\Http\Controllers\UpdateController::class, 'show'])->name('updates.show');

Route::get('/announcements', [\App\Http\Controllers\AnnouncementController::class, 'index'])->name('announcements');
Route::get('/announcements/{announcement}', [\App\Http\Controllers\AnnouncementController::class, 'show'])->name('announcements.show');

Route::get('/quotes/page/{page}', [\App\Http\Controllers\QuoteController::class, 'index'])->name('quotes.page.show');
Route::get('/themes/page/{page}', [\App\Http\Controllers\ThemeController::class, 'index'])->name('themes.page.show');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::prefix('filemanager')->middleware('web', 'auth')->group(function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('login/google', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'redirectToProvider'])->name('login.google');
Route::get('login/google/callback', [\App\Http\Controllers\Auth\GoogleLoginController::class, 'handleProviderCallback']);
Route::get('login/facebook', [\App\Http\Controllers\Auth\FacebookLoginController::class, 'redirectToProvider'])->name('login.facebook');
Route::get('login/facebook/callback', [\App\Http\Controllers\Auth\FacebookLoginController::class, 'handleProviderCallback']);
Route::get('login/instagram/auth', \App\Http\Controllers\Auth\InstagramAuthController::class)->name('login.instagram.auth');

Route::get('login/constantcontact', [\App\Http\Controllers\Auth\ConstantContactController::class, 'redirectToProvider'])->name('login.constantcontact');
Route::get('login/constantcontact/callback', [\App\Http\Controllers\Auth\ConstantContactController::class, 'handleProviderCallback']);

Route::get('login/terms-of-use', [\App\Http\Controllers\Auth\AcceptTermsOfUseController::class, 'show'])->name('terms.accept');
Route::post('login/terms-of-use', [\App\Http\Controllers\Auth\AcceptTermsOfUseController::class, 'submit'])->name('terms.submit');

/* Conference Routes */

Route::get('/conference/2023-building-latter-day-faith', \App\Http\Controllers\ConferenceController::class)->name('conference.landing-page');
Route::get('/conference/art-contest-entry-form', \App\Http\Livewire\Forms\ContestSubmissionForm::class)->name('conference.art-contest-entry-form');
Route::get('/conference/art-contest-entry-form-collaborator/{submission}', \App\Http\Livewire\Forms\ContestantContactInformationForm::class)->name('conference.art-contest-entry-form-collaborator');

/*Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});*/

Route::get('/s/wilford-woodruff-papers/documents', function () {
    return redirect()->route('documents');
});
Route::get('/s/wilford-woodruff-papers/page/people', function () {
    return redirect()->route('people');
});
Route::get('/s/wilford-woodruff-papers/page/places', function () {
    return redirect()->route('places');
});
Route::get('/s/wilford-woodruff-papers/page/timeline', function () {
    return redirect()->route('timeline');
});
Route::get('/s/wilford-woodruff-papers/page/meet-the-team', function () {
    return redirect()->route('team');
});
Route::get('/s/wilford-woodruff-papers/page/donate-online', function () {
    return redirect()->route('donate.online');
});
Route::get('/s/wilford-woodruff-papers/page/donation-questions', function () {
    return redirect()->route('donate.questions');
});
Route::get('/s/wilford-woodruff-papers/page/volunteer', function () {
    return redirect()->route('volunteer');
});
Route::get('/s/wilford-woodruff-papers/page/contribute-documents', function () {
    return redirect()->route('contribute-documents');
});
Route::get('/s/wilford-woodruff-papers/page/about', function () {
    return redirect()->route('about');
});
Route::get('/s/wilford-woodruff-papers/page/meet-the-team', function () {
    return redirect()->route('about.meet-the-team');
});
Route::get('/s/wilford-woodruff-papers/page/editorial-method', function () {
    return redirect()->route('about.editorial-method');
});
Route::get('/s/wilford-woodruff-papers/page/newsroom', function () {
    return redirect()->route('media.news');
});
Route::get('/s/wilford-woodruff-papers/page/media-requests', function () {
    return redirect()->route('media.requests');
});
Route::get('/s/wilford-woodruff-papers/page/media-kit', function () {
    return redirect()->route('media.kit');
});
Route::get('/s/wilford-woodruff-papers/page/videos', function () {
    return redirect()->route('media.videos');
});
Route::get('/s/wilford-woodruff-papers/page/podcasts', function () {
    return redirect()->route('media.podcasts');
});
Route::get('/s/wilford-woodruff-papers/photos', function () {
    return redirect()->route('media.photos');
});
Route::get('/s/wilford-woodruff-papers/media', function () {
    return redirect()->route('advanced-search');
});
Route::get('/s/wilford-woodruff-papers/item/search', function () {
    return redirect()->route('advanced-search');
});
if (app()->environment('production')) {
    Route::get('/search', function () {
        return redirect()->route('advanced-search');
    });
}
Route::get('/s/wilford-woodruff-papers/page/frequently-asked-questions', function () {
    return redirect()->route('about.frequently-asked-questions');
});

Route::group(['middleware' => ['role:Super Admin|Editor']], function () {
    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/quotes', [\App\Http\Controllers\Admin\QuoteController::class, 'index'])
        ->name('admin.dashboard.quotes.index');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/search/quotes', App\Http\Livewire\Admin\Quotes\Search::class)
        ->name('admin.quotes.search');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/quotes/{quote}', [\App\Http\Controllers\Admin\QuoteController::class, 'show'])
        ->name('admin.dashboard.quotes.show');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/document/create', App\Http\Livewire\Admin\Documents\NewDocument::class)
        ->name('admin.dashboard.document.create');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/document', [\App\Http\Controllers\Admin\DocumentController::class, 'index'])
        ->name('admin.dashboard.document.index');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/document/{item}', [\App\Http\Controllers\Admin\DocumentController::class, 'show'])
        ->name('admin.dashboard.document');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/document/{item}/edit', [\App\Http\Controllers\Admin\DocumentController::class, 'edit'])
        ->name('admin.dashboard.document.edit');

    Route::middleware(['auth:sanctum', 'verified'])
        ->post('/admin/dashboard/document', [\App\Http\Controllers\Admin\DocumentController::class, 'store'])
        ->name('admin.dashboard.document.store');

    Route::middleware(['auth:sanctum', 'verified'])
        ->post('/admin/dashboard/document/{item}', [\App\Http\Controllers\Admin\DocumentController::class, 'update'])
        ->name('admin.dashboard.document.update');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/document/{item}/page/{page}', [\App\Http\Controllers\Admin\PageController::class, 'show'])
        ->name('admin.dashboard.page');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard', \App\Http\Controllers\Admin\DashboardController::class)
        ->name('admin.dashboard');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/supervisor/dashboard', [\App\Http\Controllers\Admin\SupervisorController::class, 'index'])
        ->name('admin.supervisor.dashboard');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/supervisor/individual-activity', \App\Http\Livewire\Admin\Supervisor\IndividualActivity::class)
        ->name('admin.supervisor.individual-activity');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/dashboard/goals', \App\Http\Livewire\Admin\Goals::class)
        ->name('admin.dashboard.goals.index');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/reports', \App\Http\Livewire\Admin\Reports::class)
        ->name('admin.reports.index');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/progress-matrix', \App\Http\Livewire\Admin\ProgressMatrix::class)
        ->name('admin.reports.progress-matrix');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/progress-graphic', \App\Http\Livewire\Admin\ProgressGraphic::class)
        ->name('admin.reports.progress-graphic');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/page-activity', \App\Http\Controllers\Admin\PageActivityController::class)
        ->name('admin.page-activity');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/objectives', \App\Http\Livewire\Admin\Stage::class)
        ->name('admin.reports.objectives');

    Route::middleware(['auth:sanctum', 'verified'])
        ->get('/admin/export-transcripts', \App\Http\Controllers\Admin\ExportItemFullTranscriptController::class)
        ->name('admin.items.export-transcripts');
});
