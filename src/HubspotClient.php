<?php

namespace Kitsune\HubspotForm;

use HubSpot\Client\Crm\Contacts\Model\SimplePublicObjectInputForCreate;
use HubSpot\Factory;
use Kitsune\HubspotForm\Enum\PluginOption;

class HubspotClient
{
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = get_option(PluginOption::ApiKey->value, '');
    }

    public function createContact(string $email, string $firstName, string $lastName): void
    {
        if (empty($this->apiKey)) {
            return;
        }

        $client = Factory::createWithAccessToken($this->apiKey);

        $contactInput = new SimplePublicObjectInputForCreate([
            'properties' => [
                'email' => $email,
                'firstname' => $firstName,
                'lastname' => $lastName,
            ]
        ]);

        try {
            $response = $client->crm()->contacts()->basicApi()->create($contactInput);
            error_log('HubSpot contact created: ' . print_r($response, true));
        } catch (\Exception $e) {
            error_log('Error creating HubSpot contact: ' . $e->getMessage());
        }
    }
}
