<?php

use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('register:admin', function () {
    $credentials['name'] = $this->ask('Name');
    $credentials['username'] = $this->ask('Username');
    $credentials['role'] = 'ADMIN';

    $credentials['password'] = $this->secret('Password');
    $credentials['confirm_password'] = $this->secret('Confirm Password');

    while (!(strlen($credentials['password']) > 6 && $credentials['password'] === $credentials['confirm_password'])) {
        if (strlen($credentials['password']) <= 6) {
            $this->error('Password must be more than six characters');
        }

        if ($credentials['password'] !== $credentials['confirm_password']) {
            $this->error('Password and Confirm password do not match');
        }

        $credentials['password'] = $this->secret('Password');
        $credentials['confirm_password'] = $this->secret('Confirm Password');
    }

    $credentials['password'] = bcrypt($credentials['password']);

    $admin = User::create($credentials);

    $headers = ['Name', 'Username', 'Admin'];

    $fields = [
        'Name' => $admin->name,
        'Username' => $admin->username,
        'Admin' => $admin->role === 'ADMIN'
            ? 'true' : 'false'
    ];

    $this->info('Admin created!');

    $this->table($headers, [$fields]);
})->purpose('Register an Admin user');
