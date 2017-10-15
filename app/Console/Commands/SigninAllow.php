<?php

namespace App\Console\Commands;

use App\Role;
use Illuminate\Console\Command;

class SigninAllow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signin:allow {email} {--role=writer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Allow the target google email to authenticate through google sign-in';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $role = Role::firstOrNew([
            'email' => $this->argument('email')
        ]);

        if (!in_array($this->option('role'), [Role::ROLE_ADMIN, Role::ROLE_WRITER])) {
            throw new \Exception('An invalid role type is passed. Value should only be either \'admin\' or \'writer\'.');
        }

        $role->role = $this->option('role');

        $role->save();

    }
}
