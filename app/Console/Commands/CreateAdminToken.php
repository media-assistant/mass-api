<?php

namespace App\Console\Commands;

use App\Library\Auth;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminToken extends Command
{
    protected $signature   = 'auth:token';
    protected $description = 'Generates new token for admin user. Disables all old tokens!';

    public function handle(): int
    {
        $token = Auth::createToken(User::findOrFail(User::ADMIN));

        $this->info("New token for admin user: {$token}");

        return 0;
    }
}
