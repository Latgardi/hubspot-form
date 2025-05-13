<?php

namespace Kitsune\HubspotForm\Validator;

class EmailValidator
{
    public const string EMAIL_REGEX = "/^[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+(?:\\.[a-z0-9!#$%&'*+\\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/i";

    public function validate(string $email): bool
    {
        return (bool) preg_match(self::EMAIL_REGEX, $email);
    }
}
