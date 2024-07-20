<?php

return [
  'affiliateRole' => 'AFFILIATE',
  'approvers' => [
    'affiliationRequests' => [
      'admin',
    ],
    'ventureRequests' => [
      'admin',
    ],
  ],
  'invitationCodeRequiredForRegistration' => true,
  'ventures' => [
    'validity' => [
      'default' => 30,
      'maxExtension' => 90,
    ],
  ],
];
