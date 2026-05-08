<?php

declare(strict_types=1);

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PublicEventKind: int implements HasLabel
{
    case PageView = 1;
    case KeywordQuery = 2;
    case FilterChange = 3;
    case DetailOpen = 4;
    case ErrorShown = 5;

    public function getLabel(): ?string
    {
        return match ($this) {
            self::PageView => __('common.enums.public-event-kind.page-view'),
            self::KeywordQuery => __('common.enums.public-event-kind.keyword-query'),
            self::FilterChange => __('common.enums.public-event-kind.filter-change'),
            self::DetailOpen => __('common.enums.public-event-kind.detail-open'),
            self::ErrorShown => __('common.enums.public-event-kind.error-shown'),
        };
    }
}
