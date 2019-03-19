<?php

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

use Pvtl\VoyagerPages\Page;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/{slug?}', "\App\Http\Controllers\PageController@getPage")
    ->middleware('web')
    ->where('slug', '.+');


// Which Page Controller shall we use to display the page? Page Blocks or standard page?
$pageController = '\App\Http\Controllers\PageController';

//if (class_exists('\Pvtl\VoyagerFrontend\Http\Controllers\PageController')) {
//    $pageController = '\Pvtl\VoyagerFrontend\Http\Controllers\PageController';
//}
//
//if (class_exists('\Pvtl\VoyagerPageBlocks\Providers\PageBlocksServiceProvider')) {
//    $pageController = '\Pvtl\VoyagerPageBlocks\Http\Controllers\PageController';
//}

// Get all page slugs (note it's cached for 5mins)
$pages = Cache::remember('page/slugs', 5, function () {
    return Page::all('slug');
});

$slug = Request::path() === '/' ? 'home' : Request::path();

// When the current URI is known to be a page slug, let it be a route
if ($pages->contains('slug', $slug)) {
    Route::get('/{slug?}', "$pageController@getPage")
        ->middleware('web')
        ->where('slug', '.+');
}
