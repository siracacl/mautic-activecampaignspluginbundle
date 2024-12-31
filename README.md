# mautic-activecampaignspluginbundle
Plugin to serve endpoint `/activecampaigns` with currently active campaigns per `contactId`/`lead_id`.

Tested with Mautic 5.2.1.

## How to install?

1. Download `/ActiveCampaignsPluginBundle` folder and place it in the `plugins` directory of your Mautic installation.
2. Clear the cache of your Mautic installation.
3. Go to the plugin settings in the Mautic web UI and click on "Update/Install" to detect the new plugin.

## How to use?

Perform a `GET` request to:

```
https://mautic-url.com/api/activecampaigns/{contact-id}
```

This returns a JSON array (without any additional attributes), like the following:

### Example Request

```
GET https://mautic-url.com/api/activecampaigns/1597
```

### Example Response

```json
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
```
campaign_id is the Mautic ID of the campaign the contact is in.
lead_id is the Mautic ID of the contact/lead itself.
date_added is the date the contact was added to the corresponding campaign (should be in UTC).
description is the campaign's description in Mautic.
manually_removed should always be 0 as that is the filter applied to the endpoint (meaning, contact was NOT removed from said campaign ID).

## SQL Query

The plugin executes the following SQL query:

```sql
SELECT c.id AS campaign_id, c.name, cl.lead_id AS lead_id, cl.date_added, c.description, cl.manually_removed
FROM campaign_leads cl
INNER JOIN campaigns c ON cl.campaign_id = c.id
WHERE cl.lead_id = :contactId
  AND c.is_published = 1
  AND cl.date_last_exited IS NULL
  AND cl.manually_removed = 0
  AND c.description NOT LIKE '%system%'
```
