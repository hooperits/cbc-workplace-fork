{{--
    Public-shell visual alignment for the Venture Filament panel (/app).
    Source of truth: resources/views/components/public/layout.blade.php
--}}
@include('components.public.partials.fonts')
@include('components.public.partials.shell-styles')

<style>
    /*
     * Scope loosely to the Venture panel. Filament v3 marks the body with
     * fi-body; panel id "app" is also present on layout wrappers.
     */
    body.fi-body,
    .fi-body,
    .fi-main-ctn,
    .fi-layout {
        background-color: #020617 !important; /* slate-950 */
        background-image: linear-gradient(to bottom right, #0f172a, #020617, #000000) !important;
        background-attachment: fixed !important;
        color: #f1f5f9 !important; /* slate-100 */
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
    }

    /* Replace Filament topbar with the public sticky header (injected via hook). */
    .fi-topbar {
        display: none !important;
    }

    .fi-header-heading,
    h1.fi-header-heading,
    .fi-section-header-heading {
        font-family: 'Outfit', system-ui, sans-serif !important;
        letter-spacing: -0.025em;
    }

    /* Content width matches public main (max-w-6xl + px-6 + py-16). */
    .fi-main {
        max-width: 72rem !important; /* max-w-6xl */
        margin-left: auto !important;
        margin-right: auto !important;
        width: 100% !important;
    }

    .fi-main-ctn,
    .fi-page,
    .fi-main > section {
        padding-left: 1.5rem !important;  /* px-6 */
        padding-right: 1.5rem !important;
    }

    .fi-page > section,
    .fi-main > .fi-page-content,
    main.fi-main {
        padding-top: 2rem !important;
        padding-bottom: 4rem !important;
    }

    /* Cards / grid records — offer-card tokens */
    .fi-ta-content-grid .fi-ta-record,
    .fi-section,
    .fi-card,
    .fi-infolist-section,
    .fi-wi-stats-overview-stat {
        background-color: rgba(15, 23, 42, 0.4) !important;
        border: 1px solid rgba(30, 41, 59, 0.8) !important;
        border-radius: 1rem !important; /* rounded-2xl */
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        backdrop-filter: blur(4px);
        transition: border-color 0.3s ease, background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
    }

    .fi-ta-content-grid .fi-ta-record:hover {
        background-color: rgba(15, 23, 42, 0.6) !important;
        border-color: rgba(6, 182, 212, 0.8) !important; /* cyan-500/80 */
        transform: translateY(-0.25rem);
        box-shadow: 0 10px 15px -3px rgb(6 182 212 / 0.05), 0 4px 6px -4px rgb(6 182 212 / 0.05);
    }

    /* Filters / modal panels stay dark-slate */
    .fi-ta-filters,
    .fi-modal-window {
        border-radius: 1rem;
    }

    /* Soften default Filament page chrome gaps */
    .fi-sidebar,
    .fi-sidebar-close-overlay {
        display: none !important;
    }

    /* Footer spacing when public footer is injected */
    .ldf-public-footer-host {
        margin-top: auto;
    }
</style>
