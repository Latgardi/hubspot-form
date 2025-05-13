<?php

namespace Kitsune\HubspotForm\Renderer;

class FormRenderer
{
    public function render(): string
    {
        $message = $_SESSION['hubspot_form_message'] ?? '';
        $error = $_SESSION['hubspot_form_error'] ?? '';
        unset($_SESSION['hubspot_form_message'], $_SESSION['hubspot_form_error']);

        ob_start(); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">
        <form method="post" class="hubspot-form box" style="max-width: 600px; margin: auto;">
            <?php if ($message): ?>
                <div class="notification is-success"><?= esc_html($message) ?></div>
            <?php elseif ($error): ?>
                <div class="notification is-danger"><?= esc_html($error) ?></div>
            <?php endif; ?>

            <div class="field">
                <label class="label">First Name</label>
                <div class="control">
                    <input class="input" type="text" name="first_name" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Last Name</label>
                <div class="control">
                    <input class="input" type="text" name="last_name" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Subject</label>
                <div class="control">
                    <input class="input" type="text" name="subject" required>
                </div>
            </div>

            <div class="field">
                <label class="label">Message</label>
                <div class="control">
                    <textarea class="textarea" name="message" rows="5" required></textarea>
                </div>
            </div>

            <div class="field">
                <label class="label">E-mail</label>
                <div class="control">
                    <input class="input" type="email" name="email" required>
                </div>
            </div>

            <input type="hidden" name="hubspot_form_submitted" value="1">

            <div class="field is-grouped is-grouped-right">
                <div class="control">
                    <button type="submit" class="button is-link">Send</button>
                </div>
            </div>
        </form>
        <?php
        return ob_get_clean();
    }
}
