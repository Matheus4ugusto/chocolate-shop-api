<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUserPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:list {userEmail : Email of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the permissions of the selected user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userEmail = $this->argument('userEmail');

        $user = User::where('email', $userEmail)->first();

        $this->info($user->name);

        $this->table(
            ['Id', 'Name'],
            $user->permissions->map(function ($permission) {
                return ['id' => $permission->id, 'name' => $permission->name];
            })
        );
    }
}
