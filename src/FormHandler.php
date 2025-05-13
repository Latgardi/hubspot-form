<?php

namespace Kitsune\HubspotForm;

use Kitsune\HubspotForm\Enum\FormMessage;
use Kitsune\HubspotForm\Validator\EmailValidator;

class FormHandler
{
    private EmailValidator $validator;

    public function __construct(EmailValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle(array $data): void
    {
        $this->startSessionIfNeeded();

        $email = sanitize_email($data['email'] ?? '');
        $firstName = sanitize_text_field($data['first_name'] ?? '');
        $lastName = sanitize_text_field($data['last_name'] ?? '');
        $subject = sanitize_text_field($data['subject'] ?? '');
        $message = sanitize_textarea_field($data['message'] ?? '');

        if (!$this->validator->validate($email)) {
            $this->setSessionError();
            return;
        }

        $this->sendEmail($email, $firstName, $lastName, $subject, $message);
        $this->logMessage($email, $subject);
        $this->createHubspotContact($email, $firstName, $lastName);

        $this->setSessionSuccess();
    }

    private function startSessionIfNeeded(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    private function sendEmail(string $email, string $firstName, string $lastName, string $subject, string $message): void
    {
        $body = "From: {$firstName} {$lastName}\n\n" . $message;
        wp_mail(get_option('hubspot_recipient_email'), $subject, $body);
    }

    private function logMessage(string $email, string $subject): void
    {
        $logDir = plugin_dir_path(__DIR__) . 'log';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $logFile = $logDir . '/messages.log';
        $entry = date('Y-m-d H:i:s') . " | {$email} | {$subject}\n";
        file_put_contents($logFile, $entry, FILE_APPEND);
    }

    private function createHubspotContact(string $email, string $firstName, string $lastName): void
    {
        $hubspot = new HubspotClient();
        $hubspot->createContact($email, $firstName, $lastName);
    }

    private function setSessionError(): void
    {
        $_SESSION['hubspot_form_error'] = FormMessage::ContactCreationFailed->value;
    }

    private function setSessionSuccess(): void
    {
        $_SESSION['hubspot_form_message'] = FormMessage::Success->value;
    }
}
