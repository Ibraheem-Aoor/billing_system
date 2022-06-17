<?php

namespace Database\Seeders\Auth;

use App\Models\Core\Auth\Permission;
use App\Models\Core\Auth\Role;
use App\Models\Core\Auth\Type;
use App\Models\Core\Auth\User;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

/**
 * Class PermissionRoleTableSeeder.
 */
class PermissionRoleTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        Role::query()->truncate();
        // Create Roles
        $superAdmin = User::first();

        $roles = [
            [
                'name' => config('access.users.app_admin_role'),
                'is_admin' => 1,
                'type_id' => Type::findByAlias('app')->id,
                'created_by' => $superAdmin->id,
                'is_default' => 1
            ],
            [
                'name' => 'Client',
                'alias' => 'client',
                'type_id' => Type::findByAlias('app')->id,
                'created_by' => $superAdmin->id,
            ]
        ];
        foreach ($roles as $role) {
            Role::query()->insert($role);
        }

        $clientRole = Role::where('alias', 'client')->first();

        $clientPermission = Permission::whereIn('name',
            [
                'view_dashboard',
                'dashboard_card',
                'payment_overview',
                'yearly_overview',
                'view_invoices',
                'view_payment_histories',
                'invoice_download',
                'invoice_checkout',
                'payment_summary_reports',
                'client_statement_report_reports',
                'invoice_report_reports'
            ]
        )->get();

        $client = [];
        foreach ($clientPermission as $permission) {
            $client[] = [
                'permission_id' => $permission->id
            ];
        }
        $clientRole->permissions()->sync($client);

        //Role::query()->insert($roles);

        $this->enableForeignKeys();
    }
}
