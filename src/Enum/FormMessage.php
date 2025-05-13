<?php

namespace Kitsune\HubspotForm\Enum;

enum FormMessage: string
{
    case InvalidEmail = 'Invalid email address.';
    case ContactCreationFailed = 'Failed to create contact in HubSpot.';
    case Success = 'Thank you! Your message was sent.';
}
