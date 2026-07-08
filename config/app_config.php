<?php

return [
    'social' => [
        'networks' => [
            'X' => 'X',
            'Youtube' => 'Youtube',
            'Facebook' => 'Facebook',
            'LinkedIn' => 'LinkedIn',
            'Instagram' => 'Instagram',
        ],
    ],
    'ventures' => [
        'validity' => [
            'default' => 90,
            'maxExtension' => 90,
        ],
        'deleteExpiredVenturesAfterDays' => 30,
    ],
    'rateLimiter' => [
        'login' => 5,
        'register' => 5,
    ],
    'affiliateRole' => 'AFFILIATE',
    'affiliateImageGallery' => [
        'max' => 3,
    ],
    'invitationCodeRequiredForRegistration' => false,

    // Editable content types (used by TextResource)
    'textTypes' => [
        'ui'        => 'UI / Contenido Público',
        'mail'      => 'Plantillas de Correo',
        'versiculo' => 'Versículo de Inspiración',
    ],

    // Category scopes exposed in Sistema > Configuración and used by CategoryResource "Para" select.
    // Allows the Job Board (added later) to register its own category namespace alongside Ventures.
    // Keys MUST match the 'scope' column values actually used in the DB (JobListing for jobs).
    'categories' => [
        'Venture'    => 'Emprendimiento',
        'JobListing' => 'Bolsa de Trabajo',
    ],
];
