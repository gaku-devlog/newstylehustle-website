<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CommunityRepController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReadingPageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

if (app()->environment('production')) {
    URL::forceScheme('https');
}

Route::middleware('auth')->group(function (): void {
    Route::get('communityrep/communitycreate', [CommunityRepController::class, 'communityadd']);
    Route::post('communityrep/communitycreate', [CommunityRepController::class, 'communitycreate']);
    Route::get('communityrep/communityedit', [CommunityRepController::class, 'communityedit']);
    Route::post('communityrep/communityedit', [CommunityRepController::class, 'communityupdate']);
    Route::get('communityrep/communitydelete', [CommunityRepController::class, 'communitydelete']);
    Route::get('communityrep', [CommunityRepController::class, 'index']);
    Route::get('communityrep/newscreate', [CommunityRepController::class, 'newsadd']);
    Route::post('communityrep/newscreate', [CommunityRepController::class, 'newscreate']);
    Route::get('communityrep/newsedit', [CommunityRepController::class, 'newsedit']);
    Route::post('communityrep/newsedit', [CommunityRepController::class, 'newsupdate']);
    Route::get('communityrep/newsdelete', [CommunityRepController::class, 'newsdelete']);
});

Route::middleware('guest')->group(function (): void {
    Route::get('communityrep_login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('communityrep_login', [LoginController::class, 'login']);
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
    Route::get('GcnJBe6DwdsK_register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('GcnJBe6DwdsK_register', [RegisterController::class, 'register']);
});

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('home', [HomeController::class, 'index'])->name('home');
Route::get('/', [ReadingPageController::class, 'toppage']);
Route::get('community/{permalink}', [ReadingPageController::class, 'communityshow']);
Route::get('news/{news_permalink}', [ReadingPageController::class, 'newsshow']);
Route::get('about-newstylehustle', [ReadingPageController::class, 'about']);
Route::get('news', [ReadingPageController::class, 'indexnews']);
Route::get('lesson', [ReadingPageController::class, 'lessonshow']);
Route::get('featured-video', [ReadingPageController::class, 'videopageshow']);
Route::get('community', [ReadingPageController::class, 'indexcommunity']);
Route::get('search', [SearchController::class, 'index']);
Route::get('privacy_policy', [ReadingPageController::class, 'privacypolicy']);
Route::get('disclaimer', [ReadingPageController::class, 'disclaimer']);
Route::get('about', [ReadingPageController::class, 'regarding']);
Route::get('contact', [ContactsController::class, 'index']);
Route::post('contact/confirm', [ContactsController::class, 'confirm']);
Route::post('contact/correct', [ContactsController::class, 'correct']);
Route::post('contact/complete', [ContactsController::class, 'complete']);
Route::get('sitemap', SitemapController::class)->name('sitemap');
Route::get('sitemap.xml', SitemapController::class);
