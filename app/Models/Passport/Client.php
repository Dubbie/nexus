<?php

namespace App\Models\Passport;

use Laravel\Passport\Client as BaseClient;

class Client extends BaseClient
{
    public function skipsAuthorization()
    {
        // Decide based on if the client is trusted
        return $this->trusted ?? false;
    }
}
