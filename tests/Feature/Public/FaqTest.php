<?php

namespace Tests\Feature\Public;

use App\Enums\FaqModule;
use App\Http\Controllers\Public\FaqController;
use App\Models\Faq;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaqTest extends TestCase
{
    use RefreshDatabase;

    public function test_faq_index_renders_active_faqs(): void
    {
        Faq::factory()->create([
            'question' => 'Pregunta visible?',
            'is_active' => true,
            'module' => FaqModule::GENERAL,
        ]);
        Faq::factory()->inactive()->create([
            'question' => 'Pregunta oculta?',
        ]);

        $this->get(route('public.faqs'))
            ->assertOk()
            ->assertSee('Pregunta visible?', false)
            ->assertDontSee('Pregunta oculta?', false);
    }

    public function test_faq_index_filters_by_module(): void
    {
        Faq::factory()->create([
            'question' => 'FAQ de bolsa?',
            'module' => FaqModule::JOB_BOARD,
        ]);
        Faq::factory()->venture()->create([
            'question' => 'FAQ de emprendimiento?',
        ]);

        $this->get(route('public.faqs', ['module' => 'job_board']))
            ->assertOk()
            ->assertSee('FAQ de bolsa?', false)
            ->assertDontSee('FAQ de emprendimiento?', false);
    }

    public function test_faq_index_searches_by_question(): void
    {
        Faq::factory()->create(['question' => 'Cómo postular a vacantes?']);
        Faq::factory()->create(['question' => 'Cómo publicar un emprendimiento?']);

        $this->get(route('public.faqs', ['q' => 'postular']))
            ->assertOk()
            ->assertSee('Cómo postular a vacantes?', false)
            ->assertDontSee('Cómo publicar un emprendimiento?', false);
    }

    public function test_faq_index_paginates(): void
    {
        Faq::factory()->count(FaqController::PER_PAGE + 3)->create([
            'module' => FaqModule::GENERAL,
        ]);

        $this->get(route('public.faqs'))
            ->assertOk()
            ->assertSee('Siguiente', false);

        $this->get(route('public.faqs', ['page' => 2]))
            ->assertOk();
    }

    public function test_home_shows_module_previews_not_all_faqs(): void
    {
        Faq::factory()->count(5)->venture()->create();
        Faq::factory()->count(5)->jobBoard()->create();

        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee(url('/preguntas-frecuentes'), false);
        $response->assertSee(__('public-faq.home.view_all'), false);
    }

    public function test_invalid_module_falls_back_to_all(): void
    {
        Faq::factory()->create(['question' => 'Cualquier FAQ?']);

        $this->get(route('public.faqs', ['module' => 'invalid']))
            ->assertOk()
            ->assertSee('Cualquier FAQ?', false);
    }
}
