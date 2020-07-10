<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class CreateAdminUserCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create:admin {name} {email} {--type=admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create admin user';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');

        if (User::where('email', '=', $email)->first()) {
            return $this->error("The email [{$email}] already exists.");
        }

        $user = new User([
            'email' => $email,
            'name' => $name,
            'type' => $this->option('type')
        ]);

        $user->password = bcrypt($this->getPassword());

        if ($this->confirm("Create {$user->name} : {$user->email}?", true)) {
            $user->saveOrFail();

            $this->info('User '.$user->name.' has been created.');
            $this->line('Email: '.$email);
        }
    }

    public function getPassword()
    {
        $password = $this->secret('Password');
        $password_confirm = $this->secret('Confirm password');

        if ($password != $password_confirm) {
            $this->error('Passwords do not match.');

            return $this->getPassword();
        }

        return $password;
    }

}
