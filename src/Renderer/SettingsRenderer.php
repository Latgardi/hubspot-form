<?php

namespace Kitsune\HubspotForm\Renderer;

use Kitsune\HubspotForm\Enum\PluginOption;
use Kitsune\HubspotForm\Plugin;

class SettingsRenderer
{
    public function render(): void
    {
        ?>
        <div class="wrap">
            <h1>HubSpot Form Settings</h1>
            <form method="post" action="options.php">
                <?php settings_fields(Plugin::OPTION_GROUP); ?>
                <?php do_settings_sections(Plugin::OPTION_GROUP); ?>
                <table class="form-table" role="presentation">
                    <tbody>
                    <tr>
                        <th scope="row"><label for="<?= PluginOption::ApiKey->value ?>">HubSpot API Key</label></th>
                        <td>
                            <input
                                    type="text"
                                    id="<?= PluginOption::ApiKey->value ?>"
                                    name="<?= PluginOption::ApiKey->value ?>"
                                    value="<?php echo esc_attr(get_option(PluginOption::ApiKey->value, '')); ?>"
                                    class="regular-text"
                            />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="<?= PluginOption::RecipientEmail->value ?>">Recipient Email</label></th>
                        <td>
                            <input
                                    type="email"
                                    id="<?= PluginOption::RecipientEmail->value ?>"
                                    name="<?= PluginOption::RecipientEmail->value ?>"
                                    value="<?php echo esc_attr(get_option(PluginOption::RecipientEmail->value)); ?>"
                                    class="regular-text"
                            />
                            <p class="description">Email address where form submissions will be sent.</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}
