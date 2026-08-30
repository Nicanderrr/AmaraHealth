<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConsultationCallRequestController;
use App\Http\Controllers\ConsultationCallSessionController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\CycleTrackerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HealthArticleController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\Admin\ConsultationController as AdminConsultationController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProfessionalController as AdminProfessionalController;
use App\Http\Controllers\Admin\ForumModerationController;
use App\Http\Controllers\Admin\HealthArticleController as AdminHealthArticleController;
use App\Http\Controllers\Admin\ResourceController as AdminResourceController;
use App\Http\Controllers\Admin\ConsultationRecordingController as AdminConsultationRecordingController;
use App\Http\Controllers\Admin\SiteSettingsController as AdminSiteSettingsController;
use App\Http\Controllers\Professional\CallSessionController as ProfessionalCallSessionController;
use App\Http\Controllers\Professional\CallRequestController as ProfessionalCallRequestController;
use App\Http\Controllers\Professional\ConsultationController as ProfessionalConsultationController;
use App\Http\Controllers\Professional\DashboardController as ProfessionalDashboardController;
use App\Http\Controllers\Professional\ForumReviewController as ProfessionalForumReviewController;
use App\Http\Controllers\Professional\HealthArticleController as ProfessionalHealthArticleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/library', [HealthArticleController::class, 'index'])->name('articles.index');
Route::get('/library/{article}', [HealthArticleController::class, 'show'])->name('articles.show');

Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');

Route::get('/forum', [ForumController::class, 'index'])->name('forum.index');
Route::get('/forum/create', [ForumController::class, 'create'])->middleware('auth')->name('forum.create');
Route::post('/forum', [ForumController::class, 'store'])->middleware('auth')->name('forum.store');
Route::get('/forum/{forum}', [ForumController::class, 'show'])->name('forum.show');
Route::post('/forum/{forum}/reply', [ForumController::class, 'reply'])->middleware('auth')->name('forum.reply');

Route::get('/consultation', [ConsultationController::class, 'create'])->middleware('auth')->name('consultations.create');
Route::post('/consultation', [ConsultationController::class, 'store'])->middleware('auth')->name('consultations.store');
Route::get('/consultation/{consultationRequest}', [ConsultationController::class, 'show'])
    ->middleware('auth')
    ->name('consultations.show');
Route::get('/consultations', [ConsultationController::class, 'index'])->middleware('auth')->name('consultations.index');
Route::post('/consultations/{consultation}/call-requests', [ConsultationCallRequestController::class, 'store'])
    ->middleware('auth')
    ->name('consultations.call-requests.store');
Route::get('/call-sessions/{callSession}', [ConsultationCallSessionController::class, 'show'])
    ->middleware('auth')
    ->name('call-sessions.show');
Route::post('/call-sessions/{callSession}/consent', [ConsultationCallSessionController::class, 'consent'])
    ->middleware('auth')
    ->name('call-sessions.consent');

Route::get('/tracker', [CycleTrackerController::class, 'index'])->middleware('auth')->name('tracker.index');
Route::post('/tracker', [CycleTrackerController::class, 'store'])->middleware('auth')->name('tracker.store');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/profile', [ProfileController::class, 'edit'])->middleware('auth')->name('profile.edit');
Route::put('/profile', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');
Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->middleware('auth')->name('profile.password.update');
Route::get('/notifications/{notification}', [NotificationController::class, 'open'])
    ->middleware('auth')
    ->name('notifications.open');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])
    ->middleware('auth')
    ->name('notifications.mark-all-read');

Route::get('/login', [AuthController::class, 'createLogin'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'storeLogin'])->middleware('guest')->name('login.store');
Route::get('/register', [AuthController::class, 'createRegister'])->middleware('guest')->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->middleware('guest')->name('register.store');
Route::post('/logout', [AuthController::class, 'destroy'])->middleware('auth')->name('logout');

Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('site-settings', [AdminSiteSettingsController::class, 'edit'])->name('settings.edit');
        Route::put('site-settings', [AdminSiteSettingsController::class, 'update'])->name('settings.update');
        Route::get('professionals', [AdminProfessionalController::class, 'index'])->name('professionals.index');
        Route::get('professionals/create', [AdminProfessionalController::class, 'create'])->name('professionals.create');
        Route::post('professionals', [AdminProfessionalController::class, 'store'])->name('professionals.store');
        Route::resource('articles', AdminHealthArticleController::class)->except(['show']);
        Route::resource('resources', AdminResourceController::class)->except(['show']);
        Route::get('consultations', [AdminConsultationController::class, 'index'])->name('consultations.index');
        Route::get('consultations/{consultation}', [AdminConsultationController::class, 'show'])->name('consultations.show');
        Route::put('consultations/{consultation}', [AdminConsultationController::class, 'update'])->name('consultations.update');
        Route::get('call-recordings/{recording}', [AdminConsultationRecordingController::class, 'show'])->name('recordings.show');
        Route::get('forum', [ForumModerationController::class, 'index'])->name('forum.index');
        Route::get('forum/{topic}', [ForumModerationController::class, 'show'])->name('forum.show');
        Route::patch('forum/{topic}/moderation', [ForumModerationController::class, 'moderateTopic'])->name('forum.moderate-topic');
        Route::patch('forum/{topic}/replies/{reply}/moderation', [ForumModerationController::class, 'moderateReply'])->name('forum.moderate-reply');
        Route::post('forum/{topic}/contact-author', [ForumModerationController::class, 'contactTopicAuthor'])->name('forum.contact-topic-author');
        Route::post('forum/{topic}/replies/{reply}/contact-author', [ForumModerationController::class, 'contactReplyAuthor'])->name('forum.contact-reply-author');
        Route::patch('forum/{topic}/toggle-lock', [ForumModerationController::class, 'toggleLock'])->name('forum.toggle');
        Route::delete('forum/{topic}', [ForumModerationController::class, 'destroy'])->name('forum.destroy');
    });

Route::prefix('professional')
    ->middleware(['auth', 'professional'])
    ->name('professional.')
    ->group(function () {
        Route::get('/', [ProfessionalDashboardController::class, 'index'])->name('dashboard');
        Route::resource('articles', ProfessionalHealthArticleController::class)->only(['index', 'create', 'store']);
        Route::get('forum', [ProfessionalForumReviewController::class, 'index'])->name('forum.index');
        Route::get('forum/{topic}', [ProfessionalForumReviewController::class, 'show'])->name('forum.show');
        Route::patch('forum/{topic}/moderation', [ProfessionalForumReviewController::class, 'moderateTopic'])->name('forum.moderate-topic');
        Route::patch('forum/{topic}/replies/{reply}/moderation', [ProfessionalForumReviewController::class, 'moderateReply'])->name('forum.moderate-reply');
        Route::post('forum/{topic}/clarify', [ProfessionalForumReviewController::class, 'clarify'])->name('forum.clarify');
        Route::post('forum/{topic}/contact-author', [ProfessionalForumReviewController::class, 'contactTopicAuthor'])->name('forum.contact-topic-author');
        Route::get('consultations', [ProfessionalConsultationController::class, 'index'])->name('consultations.index');
        Route::get('consultations/{consultation}', [ProfessionalConsultationController::class, 'show'])->name('consultations.show');
        Route::put('consultations/{consultation}', [ProfessionalConsultationController::class, 'update'])->name('consultations.update');
        Route::post('consultations/{consultation}/call-sessions', [ProfessionalCallSessionController::class, 'store'])->name('consultations.call-sessions.store');
        Route::put('call-requests/{callRequest}', [ProfessionalCallRequestController::class, 'update'])->name('call-requests.update');
    });
