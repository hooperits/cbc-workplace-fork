<?php

return [
    'navigation' => 'Inicio',
    'title' => 'Bolsa de Trabajo',
    'subtitle' => '¿Qué quieres hacer hoy? Puedes buscar empleo, contratar talento, o ambas cosas.',
    'greeting' => 'Hola, :name',
    'greeting_fallback' => 'Hola',
    'progress_label' => ':done de :total pasos',
    'next_step' => 'Siguiente paso',
    'quick' => [
        'heading' => 'Accesos rápidos',
        'profile' => 'Mi hoja de vida',
        'applications' => 'Postulaciones',
        'alerts' => 'Alertas',
        'org' => 'Mi organización',
        'listings' => 'Mis ofertas',
        'browse' => 'Explorar vacantes',
    ],

    'status' => [
        'ready_to_apply' => 'Listo para postular a vacantes.',
        'profile_incomplete' => 'Tu hoja de vida está incompleta: completa los datos básicos para postular con más fuerza.',
        'no_profile' => 'Aún no tienes hoja de vida. Créala para poder postular.',
        'org_suspended' => 'Tu organización está suspendida. No puedes publicar ni gestionar vacantes.',
        'org_pending' => 'Tu organización está en revisión. Cuando sea verificada podrás publicar vacantes.',
        'org_ready' => 'Tu organización está verificada. Ya puedes publicar vacantes.',
        'no_org' => 'Para publicar vacantes, registra primero tu organización.',
    ],

    'candidate' => [
        'title' => 'Busco empleo',
        'description' => 'Completa tu hoja de vida y postula a vacantes de la comunidad.',
        'steps' => [
            'profile' => 'Crear mi hoja de vida',
            'profile_done' => 'Hoja de vida creada',
            'complete' => 'Completar datos básicos (título, ciudad, teléfono)',
            'complete_done' => 'Datos básicos listos',
            'browse' => 'Explorar vacantes y postular',
            'applications' => 'Ver mis postulaciones',
        ],
        'cta' => [
            'create_profile' => 'Crear hoja de vida',
            'edit_profile' => 'Editar hoja de vida',
            'complete_profile' => 'Completar hoja de vida',
            'browse' => 'Ver ofertas de empleo',
            'applications' => 'Mis postulaciones',
        ],
    ],

    'employer' => [
        'title' => 'Quiero contratar',
        'description' => 'Registra tu organización y publica vacantes cuando esté verificada.',
        'steps' => [
            'org' => 'Registrar mi organización',
            'org_done' => 'Organización registrada',
            'verify' => 'Esperar verificación de la organización',
            'verify_done' => 'Organización verificada',
            'verify_pending' => 'Verificación en curso',
            'publish' => 'Publicar una vacante',
            'manage' => 'Gestionar mis ofertas y postulantes',
        ],
        'cta' => [
            'create_org' => 'Registrar organización',
            'view_org' => 'Ver mi organización',
            'create_listing' => 'Publicar vacante',
            'listings' => 'Mis ofertas',
        ],
    ],

    'gates' => [
        'publish_need_org' => 'Para publicar una vacante primero registra tu organización.',
        'publish_need_verification' => 'Tu organización debe estar verificada antes de publicar vacantes. Revisa el estado en Mi Organización.',
        'publish_suspended' => 'Tu organización está suspendida. No puedes crear vacantes.',
        'apply_need_profile' => 'Para postular necesitas una hoja de vida. Créala y vuelve a la oferta.',
        'apply_create_profile' => 'Crear hoja de vida',
        'apply_back_to_offer' => 'Volver a la oferta',
    ],

    'empty' => [
        'applications' => [
            'heading' => 'Aún no has postulado',
            'description' => 'Explora la bolsa de trabajo y postula a vacantes que te interesen.',
            'action' => 'Explorar vacantes',
        ],
        'listings' => [
            'no_org_heading' => 'Primero registra tu organización',
            'no_org_description' => 'Las vacantes se publican a nombre de una organización verificada.',
            'no_org_action' => 'Registrar organización',
            'pending_heading' => 'Organización en verificación',
            'pending_description' => 'Cuando aprueben tu organización podrás publicar vacantes aquí.',
            'pending_action' => 'Ver mi organización',
            'ready_heading' => 'Aún no has publicado vacantes',
            'ready_description' => 'Publica tu primera oferta para recibir postulaciones de la comunidad.',
            'ready_action' => 'Publicar vacante',
        ],
    ],
];
