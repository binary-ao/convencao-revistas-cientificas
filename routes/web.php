<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\RegistrationLookupController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SpeakerController;
use App\Http\Controllers\WorkshopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rotas públicas — Fases 2 e 3
|--------------------------------------------------------------------------
| Validação de certificado fica para a Fase 5 (ver secção B da arquitectura).
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/sobre', [AboutController::class, 'index'])->name('about');
Route::get('/programa', [ProgramController::class, 'index'])->name('program');
Route::get('/oradores', [SpeakerController::class, 'index'])->name('speakers.index');
Route::get('/oradores/{speaker:slug}', [SpeakerController::class, 'show'])->name('speakers.show');
Route::get('/workshops', [WorkshopController::class, 'index'])->name('workshops.index');
Route::get('/cursos', [CourseController::class, 'index'])->name('courses.index');
Route::get('/parceiros', [PartnerController::class, 'index'])->name('partners.index');
Route::get('/noticias', [NewsController::class, 'index'])->name('news.index');
Route::get('/noticias/{news:slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/documentos', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/galeria', [GalleryController::class, 'index'])->name('gallery.index');
Route::get('/galeria/{album:slug}', [GalleryController::class, 'show'])->name('gallery.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq');
Route::get('/contactos', [ContactController::class, 'index'])->name('contacts');
Route::get('/politica-de-privacidade', [PolicyController::class, 'privacy'])->name('privacy');
Route::get('/termos', [PolicyController::class, 'terms'])->name('terms');
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

Route::prefix('inscricao')->name('registration.')->group(function () {
    Route::get('/', [RegistrationController::class, 'create'])->name('create');
    Route::post('/', [RegistrationController::class, 'store'])->middleware('throttle:6,1')->name('store');
    Route::get('/sucesso/{registration:code}', [RegistrationController::class, 'success'])->name('success');
    Route::get('/{registration:code}/comprovativo', [RegistrationController::class, 'downloadProof'])->name('proof');
    Route::get('/consultar', [RegistrationLookupController::class, 'show'])->name('lookup');
    Route::post('/consultar', [RegistrationLookupController::class, 'lookup'])->middleware('throttle:10,1')->name('lookup.submit');
});

Route::get('/certificado/validar', [CertificateController::class, 'showValidateForm'])->name('certificate.validate');
Route::post('/certificado/validar', [CertificateController::class, 'validateCode'])
    ->middleware('throttle:10,1')->name('certificate.validate.submit');
