<?php

namespace MauticPlugin\ActiveCampaignsPluginBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Mautic\ApiBundle\Controller\CommonApiController;

class ApiController extends CommonApiController
{
    public function getActiveCampaignsAction($id)
    {
        // Database connection
        $connection = $this->getDoctrine()->getConnection();

        // sql query
        $sql = '
            SELECT c.id AS campaign_id, c.name, cl.lead_id AS lead_id, cl.date_added, c.description, cl.manually_removed
            FROM campaign_leads cl
            INNER JOIN campaigns c ON cl.campaign_id = c.id
            WHERE cl.lead_id = :contactId
              AND c.is_published = 1
              AND cl.date_last_exited IS NULL
              AND cl.manually_removed = 0
              AND c.description NOT LIKE '%system%'
        ';

        // query
        $result = $connection->executeQuery($sql, ['contactId' => $id]);
        $campaigns = $result->fetchAllAssociative(); // fetch results

        // return in JSON
        return new JsonResponse($campaigns);
    }
}
