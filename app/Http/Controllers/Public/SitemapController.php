<?php

declare(strict_types=1);

namespace App\Http\Controllers\Public;

use App\Actions\Public\GenerateSitemapAction;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

/**
 * Serves the public sitemap (FR-023).
 *
 * Strategy:
 *  - The scheduled `app:generate-sitemap` command writes the canonical
 *    `public/sitemap.xml` once an hour.
 *  - This controller is the on-demand backstop. If the file is missing
 *    (fresh deploy, scheduler not run yet), it regenerates inline so the
 *    crawler never sees a 404.
 *
 * Lives in the cookie-free `routes/public.php` group so the response is
 * Cloudflare-cacheable.
 */
class SitemapController extends Controller
{
    public function show(): Response
    {
        $path = public_path('sitemap.xml');

        // TODO: on a fresh deploy with the scheduler not yet run, the very
        // first request triggers a synchronous full-table scan + in-memory
        // sitemap build inside the HTTP request. With thousands of active
        // offers this can hit php max_execution_time. If the active-offer
        // count grows past a few hundred, replace this with a dispatched
        // queue job + 503 Retry-After while the file is missing.
        // The atomic rename(2) inside GenerateSitemapAction protects readers
        // from a partial-write race in the meantime.
        if (! is_file($path)) {
            $result = GenerateSitemapAction::run();
            $path = $result['path'];
        }

        $xml = (string) file_get_contents($path);

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
