# mautic-activecampaignspluginbundle
Plugin to serve endpoint /activecampaigns with currently active campaign per contactId/lead_id.

Tested with Mautic 5.2.1.

# How to install?

Download /ActiveCampaignsPluginBundle folder and place it in the plugins directory of your Mautic installation.

Clear cache for Mautic installation. Might also need to go to plugin settings in Mautic web UI and click on update/install for the plugin to be found.

# How to use?

GET https://mautic-url.com/api/activecampaigns/{contact-id}

Returns array (without any attribute), like the following:

GET https://mautic-url.com/api/activecampaigns/1597

[
  {
    "campaign_id": "4",
    "name": "marketing-campaign",
    "lead_id": "1597",
    "date_added": "2024-12-30 07:50:46",
    "description": null,
    "manually_removed": "0"
  },
  {
    "campaign_id": "6",
    "name": "another-campaign",
    "lead_id": "1597",
    "date_added": "2024-12-30 07:50:47",
    "description": null,
    "manually_removed": "0"
  }
]

Equals SQL-statement

'
            SELECT c.id AS campaign_id, c.name, cl.lead_id AS lead_id, cl.date_added, c.description, cl.manually_removed
            FROM campaign_leads cl
            INNER JOIN campaigns c ON cl.campaign_id = c.id
            WHERE cl.lead_id = :contactId
              AND c.is_published = 1
              AND cl.date_last_exited IS NULL
              AND cl.manually_removed = 0
        '
