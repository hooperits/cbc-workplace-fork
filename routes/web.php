<?php

use App\Enums\FaqModule;
use App\Enums\VentureApprovalState;
use App\Http\Controllers\Public\FaqController;
use App\Models\Faq;
use App\Models\JobListing;
use App\Models\Venture;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $venturesCount = Venture::active()
        ->where('approval_state', VentureApprovalState::APPROVED)
        ->where('is_expired', 0)
        ->whereHas('member', fn ($q) => $q->where('is_active', true))
        ->count();

    $jobsCount = JobListing::active()->count();

    $ventureFaqs = Faq::active()->forModule(FaqModule::VENTURE)->ordered()->limit(3)->get();
    $jobBoardFaqs = Faq::active()->forModule(FaqModule::JOB_BOARD)->ordered()->limit(3)->get();

    return view('welcome', [
        'venturesCount' => $venturesCount,
        'jobsCount'     => $jobsCount,
        'ventureFaqs'   => $ventureFaqs,
        'jobBoardFaqs'  => $jobBoardFaqs,
    ]);
});

Route::get('/preguntas-frecuentes', FaqController::class)
    ->name('public.faqs');

Route::get('/member/tos', App\Filament\Member\Pages\Tos::class)
    ->name('member-tos');
Route::get('/member/welcome', App\Filament\Member\Pages\Welcome::class)
    ->name('member-welcome');
Route::get('/member/contact', App\Filament\Member\Pages\Contact::class)
    ->name('member-contact');
Route::get('/member/register-with-invitation-code', App\Filament\Member\Pages\InvitationCodeRequiredForRegistration::class)
    ->name('member-register-with-invitation-code');

// /app is owned by the Filament Venture panel (VenturePanelProvider path +
// ListVentures slug "/"). A standalone Livewire full-page route here would
// bypass panel render hooks (public shell chrome). Callers that previously
// used route('venture-home') should use url('/app') instead.

// Spec 007 public job-board listing lives in routes/public.php (loaded by
// RouteServiceProvider with a minimal, session-free middleware stack) so
// Cloudflare can cache the listing at the edge (FR-013, SC-001).
//
// The offer detail route below intentionally uses the standard `web` group:
// FR-019's variant-aware Apply CTA needs to read Auth state, which requires
// the session middleware. Variant-personalized responses are not edge-
// cacheable in any case, so the cookie cost is acceptable.
Route::get('/bolsa-de-trabajo/{slug}', [App\Http\Controllers\Public\JobOfferController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('public.job-offer.show');

// Spec 008 — anonymous unsubscribe via signed URL (FR-027..FR-028c).
// Long-lived signed URL: `URL::signedRoute(..., absoluteExpiresAt: null)`.
Route::get('/alerts/unsubscribe/{member}/{alert}', App\Http\Controllers\Member\UnsubscribeAlertController::class)
    ->middleware(['signed'])
    ->name('alerts.unsubscribe');
