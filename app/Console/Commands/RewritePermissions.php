<?php

namespace App\Console\Commands;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Console\Command;

class RewritePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:rewrite {userEmail : Email of the user} {--permission=* : Permissions for assignment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rewrites the permissions of the selected user.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userEmail = $this->argument('userEmail');
        $permissions = array_filter(array_unique($this->option('permission')));

        $user = User::where('email', $userEmail)->first();
        if (!$user) {
            $this->error('User not found!');
            return;
        }

        $permissionsDataBase = Permission::whereIn('name', $permissions)->get(['name', 'id']);

        if ($permissionsDataBase->count() == 0) {
            $this->error('No permissions were found!');
            return;
        }

        $permissionsNotFound = array_diff($permissions, $permissionsDataBase->pluck('name')->toArray());

        if (count($permissionsNotFound) > 0) {
            $this->warn((
                count($permissionsNotFound) > 1 ?
                'The permissions ' :
                'The permission ') . implode(', ', $permissionsNotFound) . ' were not found');
        }

        $user->permissions()->sync($permissionsDataBase->pluck('id'));
        $this->info('Success!');
    }
}
