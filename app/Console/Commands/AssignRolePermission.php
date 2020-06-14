<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\Permission;
use App\User;

class AssignRolePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:reload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign All Permission to Superadmin';

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
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $roleSuperAdmin = Role::firstOrNew(["name" => "superadmin"]);
        $roleSuperAdmin->save();

        if ($roleSuperAdmin) 
        {
            $user = User::first();
            $user->assignRole($roleSuperAdmin->name);

            $permissions = [];
            foreach (config('menus') as $module) {
                foreach ($module['permissions'] as $permission) {
                    $permissions[] = $permission.'-'.$module['route'];
                }
            }
    
            $assigned = 0;
            foreach ($permissions as $permission) {
                $cekPermission = Permission::where('name', $permission)->first();

                if (empty($cekPermission)) {
                    $cekPermission = Permission::create(['name' => $permission]);
                    $this->info($permission.' Created');
                }
              
                if (!$roleSuperAdmin->hasPermissionTo($permission)) {
                    $roleSuperAdmin->addPermission($permission);
                    $this->info($permission.' Assigned to superadmin Role');
                    $assigned += 1;
                }
            }
    
            if ($assigned == 0) {
                $this->comment('There is no new Permission');
            } else {
                $this->comment($assigned.' Permission Assigned to superadmin Role');
            }  
        } else {
            $this->info('Role not found');
        }
    }
}
