<?php

use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\CheckinController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\EventDayController;
use App\Http\Controllers\Admin\EventSessionController;
use App\Http\Controllers\Admin\EventSettingsController;
use App\Http\Controllers\Admin\GalleryAlbumController;
use App\Http\Controllers\Admin\GalleryItemController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ParticipantController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\RegistrationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SpeakerController;
use App\Http\Controllers\Admin\WorkshopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas administrativas — /admin
|--------------------------------------------------------------------------
| Guardadas pelo guard "web" por omissão: só existem contas de equipa
| organizadora em `users` (participantes nunca têm conta, ver secção 4
| da arquitectura). Papéis/permissões geridos via spatie/laravel-permission.
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'admin.active'])->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('speakers', SpeakerController::class)
            ->except('show')
            ->middleware('can:program.manage');

        Route::resource('hero-slides', HeroSlideController::class)
            ->except('show')
            ->middleware('can:content.manage');

        Route::resource('institutions', InstitutionController::class)
            ->except('show')
            ->middleware('can:program.manage');

        Route::resource('workshops', WorkshopController::class)
            ->except('show')
            ->middleware('can:program.manage');

        Route::resource('courses', CourseController::class)
            ->except('show')
            ->middleware('can:program.manage');

        Route::resource('program-days', EventDayController::class)
            ->except('show')
            ->parameters(['program-days' => 'day'])
            ->middleware('can:program.manage');

        Route::resource('program-sessions', EventSessionController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['program-sessions' => 'session'])
            ->middleware('can:program.manage');

        Route::resource('participants', ParticipantController::class)
            ->only(['index', 'edit', 'update'])
            ->middleware('can:participants.manage');

        Route::resource('registrations', RegistrationController::class)
            ->only(['index', 'show', 'edit', 'update'])
            ->middleware('can:registrations.manage');
        Route::post('registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])
            ->name('registrations.cancel')->middleware('can:registrations.cancel');
        Route::post('registrations/{registration}/confirm', [RegistrationController::class, 'confirm'])
            ->name('registrations.confirm')->middleware('can:registrations.manage');
        Route::post('registrations/{registration}/resend-proof', [RegistrationController::class, 'resendProof'])
            ->name('registrations.resend-proof')->middleware('can:registrations.resend');

        Route::get('event-settings', [EventSettingsController::class, 'edit'])
            ->name('event-settings.edit')->middleware('can:settings.manage');
        Route::put('event-settings', [EventSettingsController::class, 'update'])
            ->name('event-settings.update')->middleware('can:settings.manage');

        Route::middleware('can:checkin.manage')->group(function () {
            Route::get('checkin', [CheckinController::class, 'index'])->name('checkin.index');
            Route::post('checkin/{registration}/confirm', [CheckinController::class, 'confirm'])->name('checkin.confirm');
        });

        Route::middleware('can:certificates.manage')->group(function () {
            Route::get('certificates', [CertificateController::class, 'index'])->name('certificates.index');
            Route::post('certificates/registrations/{registration}/issue', [CertificateController::class, 'issue'])->name('certificates.issue');
            Route::post('certificates/{certificate}/send', [CertificateController::class, 'send'])->name('certificates.send');
            Route::get('certificates/{certificate}/download', [CertificateController::class, 'download'])->name('certificates.download');
        });

        Route::resource('partners', PartnerController::class)
            ->except('show')
            ->middleware('can:partners.manage');

        Route::resource('news', NewsController::class)
            ->except('show')
            ->middleware('can:content.manage');

        Route::resource('documents', DocumentController::class)
            ->except('show')
            ->middleware('can:content.manage');

        Route::resource('gallery-albums', GalleryAlbumController::class)
            ->except('show')
            ->parameters(['gallery-albums' => 'album'])
            ->middleware('can:content.manage');

        Route::resource('gallery-items', GalleryItemController::class)
            ->only(['store', 'destroy'])
            ->parameters(['gallery-items' => 'item'])
            ->middleware('can:content.manage');

        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [ReportController::class, 'index'])->name('index')->middleware('can:reports.view');
            Route::get('{type}', [ReportController::class, 'show'])->name('show')->middleware('can:reports.view');
            Route::get('{type}/export/{format}', [ReportController::class, 'export'])->name('export')->middleware('can:reports.manage');
        });

        Route::get('logs', [AuditLogController::class, 'index'])->name('logs.index')->middleware('can:logs.view');
    });
});
