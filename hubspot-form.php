<?php
/**
 * Plugin Name: Hubspot Form Plugin
 * Description: Custom form plugin that sends email and integrates with HubSpot.
 * Version: 0.1
 * Author: Kitsune
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

use Kitsune\HubspotForm\Plugin;

new Plugin();