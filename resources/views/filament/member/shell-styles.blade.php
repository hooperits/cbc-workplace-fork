@include('components.public.partials.fonts')
<style>
    :root { color-scheme: dark; }

    body.fi-body,
    .fi-body,
    .fi-main-ctn,
    .fi-layout {
        background-color: #020617 !important;
        background-image: linear-gradient(to bottom right, #0f172a, #020617, #000000) !important;
        background-attachment: fixed !important;
        font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
    }

    h1, h2, h3, .brand-logo, .fi-header-heading {
        font-family: 'Outfit', system-ui, sans-serif !important;
    }

    :focus-visible {
        outline: 3px solid #06b6d4;
        outline-offset: 2px;
    }

    ::-webkit-scrollbar { width: 8px; }
    ::-webkit-scrollbar-track { background: #0f172a; }
    ::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
    ::-webkit-scrollbar-thumb:hover { background: #475569; }

    .fi-topbar {
        background: rgba(2, 6, 23, 0.85) !important;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(15, 23, 42, 0.9) !important;
    }

    .fi-ta-content-grid .fi-ta-record,
    .fi-section,
    .fi-card,
    .fi-infolist-section,
    .fi-wi-stats-overview-stat {
        background-color: #111827 !important; /* Visible premium dark slate/gray background */
        border: 1px solid #1f2937 !important; /* Clear visible border instead of uncompiled styles */
        border-radius: 1rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.4), 0 4px 6px -4px rgba(0, 0, 0, 0.4) !important;
        transition: border-color 0.25s ease-out, box-shadow 0.25s ease-out, transform 0.25s ease-out !important;
    }

    .fi-ta-content-grid .fi-ta-record:hover,
    .fi-section:hover,
    .fi-card:hover {
        border-color: #334155 !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.6) !important;
        transform: translateY(-2px) !important;
    }

    .fi-main-ctn {
        background: transparent !important;
    }

    /* Hub page: hide empty default heading gap when heading is blank */
    .ldf-jb-hub + * ,
    .fi-page:has(.ldf-jb-hub) .fi-header-heading:empty {
        display: none;
    }
</style>
