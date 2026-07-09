<style>
    :root {
        color-scheme: dark;
        --ldf-bg-from: #0f172a; /* slate-900 */
        --ldf-bg-via: #020617; /* slate-950 */
        --ldf-bg-to: #000000;
        --ldf-surface: rgba(15, 23, 42, 0.4); /* slate-900/40 */
        --ldf-border: rgba(30, 41, 59, 0.8); /* slate-800/80 */
        --ldf-cyan: #06b6d4;
        --ldf-cyan-soft: rgba(6, 182, 212, 0.2);
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
        font-size: 15px;
        line-height: 1.65;
    }

    h1, h2, h3, .brand-logo {
        font-family: 'Outfit', system-ui, sans-serif;
        line-height: 1.35; /* room for bg-clip-text gradient titles */
    }

    /* Gradient titles clip glyphs if the box is tighter than the paint */
    h1.bg-clip-text,
    h1[class*="bg-clip-text"] {
        padding-top: 0.15em;
        padding-bottom: 0.2em;
        line-height: 1.4 !important;
        overflow: visible;
    }

    :focus-visible {
        outline: 3px solid #06b6d4;
        outline-offset: 2px;
    }

    .skip-link {
        position: absolute;
        left: -9999px;
        top: auto;
        width: 1px;
        height: 1px;
        overflow: hidden;
    }

    .skip-link:focus {
        position: static;
        width: auto;
        height: auto;
        background: #0891b2;
        color: #ffffff;
        padding: 0.5rem 1rem;
        display: inline-block;
        border-radius: 0.375rem;
    }

    /* Custom scrollbar for premium look */
    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #0f172a;
    }

    ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 9999px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    /*
     * Structural chrome (works even when Tailwind utilities are not loaded,
     * e.g. Filament panel pages that inject these partials via render hooks).
     * Public pages still also get Tailwind utility classes for the same look.
     */
    .ldf-site-header {
        position: sticky;
        top: 0;
        z-index: 50;
        background: rgba(2, 6, 23, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-bottom: 1px solid #0f172a;
    }

    .ldf-site-header__inner {
        max-width: 72rem;
        margin-left: auto;
        margin-right: auto;
        padding: 1.25rem 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
    }

    .ldf-site-header__logo {
        height: 3rem;
        width: auto;
        display: block;
    }

    @media (min-width: 768px) {
        .ldf-site-header__logo {
            height: 4rem;
        }
    }

    .ldf-site-header__actions {
        display: flex;
        align-items: center;
        gap: 2.5rem;
    }

    .ldf-site-header__nav {
        display: flex;
        align-items: center;
        gap: 3rem;
        font-size: 0.875rem;
    }

    .ldf-nav-link {
        position: relative;
        font-weight: 500;
        color: #cbd5e1; /* slate-300 */
        text-decoration: none;
        transition: color 0.15s ease;
    }

    .ldf-nav-link:hover,
    .ldf-nav-link--active {
        color: #22d3ee; /* cyan-400 */
    }

    .ldf-nav-link::after {
        content: '';
        position: absolute;
        left: 0;
        bottom: -0.25rem;
        height: 1px;
        width: 0;
        background: #22d3ee;
        transition: width 0.2s ease;
    }

    .ldf-nav-link:hover::after,
    .ldf-nav-link--active::after {
        width: 100%;
    }

    .ldf-site-header__member {
        color: #cbd5e1;
        display: inline-flex;
        transition: color 0.15s ease, transform 0.15s ease;
    }

    .ldf-site-header__member:hover {
        color: #22d3ee;
        transform: scale(1.1);
    }

    .ldf-site-footer {
        border-top: 1px solid rgba(30, 41, 59, 0.6);
        background: rgba(2, 6, 23, 0.4);
        margin-top: 5rem;
        padding: 2.5rem 0;
        text-align: center;
        font-size: 0.75rem;
        color: #64748b; /* slate-500 */
    }

    .ldf-site-footer__inner {
        max-width: 72rem;
        margin-left: auto;
        margin-right: auto;
        padding: 0 1.5rem;
    }

    @media (max-width: 640px) {
        .ldf-site-header__nav {
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .ldf-site-header__actions {
            gap: 1rem;
        }
    }
</style>

