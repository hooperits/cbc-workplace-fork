<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Para publicar mis productos y servicios, ¿debo ser miembro formal de CBC?',
                'answer' => 'No es necesario ser miembro formal de la iglesia. Puedes participar como miembro activo o incluso como asistente regular de la congregación CBC, siempre que compartas los valores y principios que promovemos en nuestra comunidad de fe.',
                'youtube_id' => null,
                'sort_order' => 1,
            ],
            [
                'question' => '¿Tiene algún costo publicar mis productos o servicios en el portal de Lazos de Fe?',
                'answer' => 'No, publicar tus productos o servicios en Lazos de Fe es completamente gratuito. Nuestra misión es facilitar el encuentro entre personas de fe sin barreras económicas.',
                'youtube_id' => null,
                'sort_order' => 2,
            ],
            [
                'question' => '¿La iglesia CBC se hace responsable sobre la garantía de los productos y servicios adquiridos?',
                'answer' => 'No. La Iglesia CBC únicamente provee la plataforma tecnológica para conectar a las partes. La responsabilidad sobre la calidad, entrega y garantía de cualquier producto o servicio es exclusiva entre el comprador y el proveedor. Recomendamos siempre dialogar directamente con la persona que ofrece el servicio.',
                'youtube_id' => null,
                'sort_order' => 3,
            ],
            [
                'question' => '¿Qué debo hacer para publicar un anuncio de producto o servicio en Lazos de Fé?',
                'answer' => 'Debes registrarte en el portal. Una vez completado tu registro, inicia sesión y haz clic en “Solicitar Afiliación”. Luego podrás crear uno o varios emprendimientos y enviarlos a aprobación. Cuando la administración apruebe tu publicación, tu emprendimiento quedará visible públicamente para toda la comunidad.',
                'youtube_id' => null,
                'sort_order' => 4,
            ],
            [
                'question' => '¿Quiénes aprueban mi solicitud de afiliación y mi emprendimiento?',
                'answer' => 'Personas autorizadas por la iglesia (administradores y líderes designados) revisan cada solicitud para garantizar que los emprendimientos cumplan con los valores y principios de nuestra congregación.',
                'youtube_id' => null,
                'sort_order' => 5,
            ],
            [
                'question' => '¿Mi emprendimiento publicado puede visualizarse desde cualquier dispositivo móvil?',
                'answer' => 'Sí. La plataforma está diseñada de forma responsiva, por lo que tus productos y servicios pueden ser vistos cómodamente desde celulares, tablets y computadoras.',
                'youtube_id' => null,
                'sort_order' => 6,
            ],
            [
                'question' => '¿Puedo subir imágenes de mis productos y servicios? ¿Cuántas?',
                'answer' => 'Sí. Puedes subir hasta 3 imágenes optimizadas para dispositivos móviles y hasta 3 imágenes de mayor resolución para computadoras de escritorio.',
                'youtube_id' => null,
                'sort_order' => 7,
            ],
            [
                'question' => '¿Cuál es el tamaño recomendado de las imágenes que puedo subir?',
                'answer' => 'El sistema te indicará los límites al momento de subirlas. Generalmente se recomiendan hasta 290 KB para versiones móviles y 640 KB para versiones de escritorio, aunque la plataforma realiza optimizaciones automáticas.',
                'youtube_id' => null,
                'sort_order' => 8,
            ],
            [
                'question' => '¿Qué tipo de emprendimientos puedo publicar?',
                'answer' => 'Puedes publicar cualquier producto o servicio que no vaya en contra de los principios, valores y doctrina que promovemos en Crossroads Bible Church (CBC). La administración se reserva el derecho de aprobar o rechazar publicaciones que no se alineen con nuestra identidad de fe.',
                'youtube_id' => null,
                'sort_order' => 9,
            ],
            [
                'question' => '¿Cómo puedo registrarme en Lazos de Fé?',
                'answer' => 'El proceso es sencillo. A continuación te mostramos un video que te guía paso a paso:',
                'youtube_id' => 'uZUWu3OtuTs',
                'sort_order' => 10,
            ],
            [
                'question' => '¿Cómo puedo publicar mi emprendimiento?',
                'answer' => 'Una vez registrado y afiliado, puedes crear y publicar tus emprendimientos fácilmente. Aquí un video que explica el proceso:',
                'youtube_id' => '__ZSCRXk6vw', // Nota: este ID parece placeholder; reemplazar por el real cuando exista
                'sort_order' => 11,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq
            );
        }
    }
}