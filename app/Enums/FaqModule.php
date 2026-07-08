<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum FaqModule: string implements HasLabel, HasColor
{
    case GENERAL = 'general';
    case VENTURE = 'venture';
    case JOB_BOARD = 'job_board';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::GENERAL => __('models/faq.modules.general'),
            self::VENTURE => __('models/faq.modules.venture'),
            self::JOB_BOARD => __('models/faq.modules.job_board'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::GENERAL => 'gray',
            self::VENTURE => 'amber',
            self::JOB_BOARD => 'cyan',
        };
    }
}
