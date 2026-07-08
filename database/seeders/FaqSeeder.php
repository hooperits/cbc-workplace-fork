<?php

namespace Database\Seeders;

use App\Enums\FaqModule;
use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General
            [
                'question' => '¿Cómo puedo registrarme en Lazos de Fe?',
                'answer' => 'El proceso es sencillo. A continuación te mostramos un video que te guía paso a paso:',
                'youtube_id' => 'uZUWu3OtuTs',
                'sort_order' => 1,
                'module' => FaqModule::GENERAL,
            ],
            [
                'question' => '¿Tiene algún costo usar la plataforma Lazos de Fe?',
                'answer' => 'No. Publicar emprendimientos, registrar tu organización o postular a vacantes es gratuito. Nuestra misión es facilitar el encuentro entre personas de fe sin barreras económicas.',
                'youtube_id' => null,
                'sort_order' => 2,
                'module' => FaqModule::GENERAL,
            ],

            // Emprendimientos
            [
                'question' => 'Para publicar mis productos y servicios, ¿debo ser miembro formal de CBC?',
                'answer' => 'No es necesario ser miembro formal de la iglesia. Puedes participar como miembro activo o incluso como asistente regular de la congregación CBC, siempre que compartas los valores y principios que promovemos en nuestra comunidad de fe.',
                'youtube_id' => null,
                'sort_order' => 1,
                'module' => FaqModule::VENTURE,
            ],
            [
                'question' => '¿Qué debo hacer para publicar un anuncio de producto o servicio?',
                'answer' => 'Debes registrarte en el portal. Una vez completado tu registro, inicia sesión y haz clic en “Solicitar Afiliación”. Luego podrás crear uno o varios emprendimientos y enviarlos a aprobación. Cuando la administración apruebe tu publicación, tu emprendimiento quedará visible públicamente para toda la comunidad.',
                'youtube_id' => null,
                'sort_order' => 2,
                'module' => FaqModule::VENTURE,
            ],
            [
                'question' => '¿Quiénes aprueban mi solicitud de afiliación y mi emprendimiento?',
                'answer' => 'Personas autorizadas por la iglesia (administradores y líderes designados) revisan cada solicitud para garantizar que los emprendimientos cumplan con los valores y principios de nuestra congregación.',
                'youtube_id' => null,
                'sort_order' => 3,
                'module' => FaqModule::VENTURE,
            ],
            [
                'question' => '¿Puedo subir imágenes de mis productos y servicios? ¿Cuántas?',
                'answer' => 'Sí. Puedes subir hasta 3 imágenes optimizadas para dispositivos móviles y hasta 3 imágenes de mayor resolución para computadoras de escritorio.',
                'youtube_id' => null,
                'sort_order' => 4,
                'module' => FaqModule::VENTURE,
            ],
            [
                'question' => '¿Qué tipo de emprendimientos puedo publicar?',
                'answer' => 'Puedes publicar cualquier producto o servicio que no vaya en contra de los principios, valores y doctrina que promovemos en Crossroads Bible Church (CBC). La administración se reserva el derecho de aprobar o rechazar publicaciones que no se alineen con nuestra identidad de fe.',
                'youtube_id' => null,
                'sort_order' => 5,
                'module' => FaqModule::VENTURE,
            ],
            [
                'question' => '¿Cómo puedo publicar mi emprendimiento?',
                'answer' => 'Una vez registrado y afiliado, puedes crear y publicar tus emprendimientos fácilmente. Aquí un video que explica el proceso:',
                'youtube_id' => '__ZSCRXk6vw',
                'sort_order' => 6,
                'module' => FaqModule::VENTURE,
            ],

            // Bolsa de Trabajo
            [
                'question' => '¿Cómo creo mi hoja de vida para postular a vacantes?',
                'answer' => 'Inicia sesión en el panel de miembros y ve a <strong>Bolsa de Trabajo → Mi Hoja de Vida</strong>. Completa tus datos profesionales, experiencia y educación. Con la hoja de vida creada podrás postular a las ofertas publicadas.',
                'youtube_id' => null,
                'sort_order' => 1,
                'module' => FaqModule::JOB_BOARD,
            ],
            [
                'question' => '¿Cómo postulo a una oferta de empleo?',
                'answer' => 'Explora las vacantes en la <a href="/bolsa-de-trabajo">Bolsa de Trabajo</a>, abre el detalle de la oferta y usa el botón de postular. Debes estar registrado y tener hoja de vida. Luego podrás seguir el estado en <strong>Mis Postulaciones</strong>.',
                'youtube_id' => null,
                'sort_order' => 2,
                'module' => FaqModule::JOB_BOARD,
            ],
            [
                'question' => '¿Cómo publico una vacante como organización?',
                'answer' => 'Registra tu organización en el panel de miembros (<strong>Quiero contratar → Mi Organización</strong>) y solicita verificación. Cuando esté verificada, podrás crear ofertas en <strong>Mis Ofertas</strong>. Las vacantes pasan por aprobación administrativa antes de publicarse.',
                'youtube_id' => null,
                'sort_order' => 3,
                'module' => FaqModule::JOB_BOARD,
            ],
            [
                'question' => '¿Puedo configurar alertas de empleo?',
                'answer' => 'Sí. En el panel de miembros, sección <strong>Mis Alertas</strong>, puedes crear alertas por categoría y/o ciudad y elegir frecuencia (instantánea, diaria o semanal). Recibirás notificaciones por correo cuando haya ofertas que coincidan.',
                'youtube_id' => null,
                'sort_order' => 4,
                'module' => FaqModule::JOB_BOARD,
            ],
            [
                'question' => '¿La iglesia interviene en el proceso de selección laboral?',
                'answer' => 'No. Lazos de Fe facilita el encuentro entre candidatos y organizaciones. La evaluación, entrevistas y decisión de contratación son responsabilidad exclusiva de la organización publicadora.',
                'youtube_id' => null,
                'sort_order' => 5,
                'module' => FaqModule::JOB_BOARD,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                array_merge($faq, ['is_active' => true])
            );
        }
    }
}
