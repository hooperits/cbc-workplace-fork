<?php

namespace App\Http\Controllers\Public;

use App\Enums\FaqModule;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FaqController extends Controller
{
    public const PER_PAGE = 8;

    public function __invoke(Request $request): View
    {
        $module = $request->string('module')->toString();
        $allowed = array_merge(['all'], array_column(FaqModule::cases(), 'value'));
        if (! in_array($module, $allowed, true)) {
            $module = 'all';
        }

        $q = trim($request->string('q')->toString());
        if (mb_strlen($q) > 200) {
            $q = mb_substr($q, 0, 200);
        }

        $faqs = Faq::query()
            ->active()
            ->ordered()
            ->when($module !== 'all', fn ($query) => $query->forModule($module))
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.addcslashes($q, '%_\\').'%';

                return $query->where(function ($inner) use ($like) {
                    $inner->where('question', 'like', $like)
                        ->orWhere('answer', 'like', $like);
                });
            })
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('public.faqs', [
            'faqs' => $faqs,
            'activeModule' => $module,
            'searchQuery' => $q,
            'modules' => FaqModule::cases(),
        ]);
    }
}
