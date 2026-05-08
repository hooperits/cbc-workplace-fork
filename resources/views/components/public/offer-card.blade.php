<article class="bg-white border border-gray-200 rounded-lg p-5 hover:border-blue-400 transition-colors">
    <h2 class="text-xl font-semibold text-gray-900 mb-1">
        <a
            href="{{ $detailUrl() }}"
            class="text-blue-700 hover:text-blue-900 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2 rounded"
        >
            {{ $offer->title }}
        </a>
    </h2>

    @if ($offer->organization)
        <p class="text-gray-700 mb-3">
            <span class="sr-only">{{ __('public.listing.row.organization') }}:</span>
            {{ $offer->organization->display_name }}
        </p>
    @endif

    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-1 gap-x-4 text-sm text-gray-600">
        @if ($offer->city)
            <div class="flex gap-2">
                <dt class="font-medium">{{ __('public.listing.row.city') }}:</dt>
                <dd>{{ $offer->city }}</dd>
            </div>
        @endif

        @if ($offer->work_modality)
            <div class="flex gap-2">
                <dt class="font-medium">{{ __('public.listing.row.work_mode') }}:</dt>
                <dd>{{ $offer->work_modality->getLabel() }}</dd>
            </div>
        @endif

        @if ($offer->contract_type)
            <div class="flex gap-2">
                <dt class="font-medium">{{ __('public.listing.row.contract_type') }}:</dt>
                <dd>{{ $offer->contract_type->getLabel() }}</dd>
            </div>
        @endif

        @if ($offer->published_at)
            <div class="flex gap-2 sm:col-span-2">
                <dt class="sr-only">{{ __('public.detail.publication_date') }}</dt>
                <dd>
                    <time datetime="{{ $offer->published_at->toIso8601String() }}">
                        {{ __('public.listing.row.published_on', ['date' => $offer->published_at->isoFormat('LL')]) }}
                    </time>
                </dd>
            </div>
        @endif
    </dl>
</article>
