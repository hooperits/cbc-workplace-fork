<?php

namespace Database\Factories;

use App\Enums\FaqModule;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Faq>
 */
class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => $this->faker->unique()->sentence().'?',
            'answer' => '<p>'.$this->faker->paragraph().'</p>',
            'youtube_id' => null,
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
            'module' => FaqModule::GENERAL,
        ];
    }

    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }

    public function venture(): static
    {
        return $this->state(fn () => ['module' => FaqModule::VENTURE]);
    }

    public function jobBoard(): static
    {
        return $this->state(fn () => ['module' => FaqModule::JOB_BOARD]);
    }
}
