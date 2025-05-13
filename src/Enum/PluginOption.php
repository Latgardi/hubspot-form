<?php

namespace Kitsune\HubspotForm\Enum;

enum PluginOption: string
{
    case ApiKey = 'hubspot_api_key';
    case RecipientEmail = 'hubspot_recipient_email';
}