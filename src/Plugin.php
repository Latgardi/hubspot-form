<?php

namespace Kitsune\HubspotForm;

use Kitsune\HubspotForm\Enum\PluginOption;
use Kitsune\HubspotForm\Renderer\FormRenderer;
use Kitsune\HubspotForm\Renderer\SettingsRenderer;

readonly class Plugin
{
    public const string OPTION_GROUP = 'hubspot_form_settings';
    private SettingsRenderer $settingsRenderer;
    public function __construct()
    {
        add_shortcode('hubspot_form', [new FormRenderer(), 'render']);
        add_action('init', [$this, 'handleFormSubmission']);
        add_action('wp_enqueue_scripts', [$this, 'enqueueAssets']);
        add_action('admin_menu', [$this, 'addSettingsPage']);
        add_action('admin_init', [$this, 'registerSettings']);
        $this->settingsRenderer = new SettingsRenderer();
    }

    public function enqueueAssets(): void
    {
        wp_enqueue_style('hubspot-form-style', plugin_dir_url(__DIR__) . 'style.css');
    }

    public function handleFormSubmission(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['hubspot_form_submitted'])) {
            $validator = new EmailValidator();
            $handler = new FormHandler($validator);
            $handler->handle($_POST);
        }
    }

    public function addSettingsPage(): void
    {
        add_options_page(
            'HubSpot Form Settings',
            'HubSpot Form',
            'manage_options',
            'hubspot-form-settings',
            [$this, 'renderSettingsPage']
        );
    }

    public function registerSettings(): void
    {
        register_setting(self::OPTION_GROUP, PluginOption::ApiKey->value);
        register_setting(self::OPTION_GROUP, PluginOption::RecipientEmail->value);
    }

    public function renderSettingsPage(): void
    {
        $this->settingsRenderer->render();
    }

}
