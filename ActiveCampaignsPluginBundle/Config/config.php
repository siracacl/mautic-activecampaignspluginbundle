<?php

return [
    'name'        => 'Active Campaigns Plugin',
    'description' => 'Displays active campaigns for a given contact ID. Usage: GET /activecampaigns/{contact-id}',
    'author'      => 'siracacl',
    'version'     => '1.0.0',
    'routes' => [
        'api' => [
            'mautic_active_campaigns_api' => [
                'path'       => '/activecampaigns/{id}',
                'controller' => 'MauticPlugin\ActiveCampaignsPluginBundle\Controller\ApiController::getActiveCampaignsAction',
                'method'     => 'GET',
            ],
        ],
    ],
];
