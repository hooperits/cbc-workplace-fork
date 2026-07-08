<?php

namespace App\Models;

use App\Enums\FaqModule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'module' => FaqModule::class,
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('module')->orderBy('sort_order');
    }

    public function scopeForModule(Builder $query, FaqModule|string $module): Builder
    {
        $value = $module instanceof FaqModule ? $module->value : $module;

        return $query->where('module', $value);
    }

    public function hasVideo(): bool
    {
        return ! empty($this->youtube_id);
    }
}
