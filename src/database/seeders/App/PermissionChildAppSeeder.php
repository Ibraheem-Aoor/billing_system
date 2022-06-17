<?php

namespace Database\Seeders\App;

use App\Models\Core\Auth\Type;
use Illuminate\Database\Seeder;
use App\Models\Core\Auth\Permission;
use Database\Seeders\Traits\DisableForeignKeys;

class PermissionChildAppSeeder extends Seeder
{
    use DisableForeignKeys;

    public function run()
    {
        $this->disableForeignKeys();
        Permission::query()->truncate();
        $appId = Type::findByAlias('app')->id;
        $permissions = [
            [
                'name' => 'show_all_data',
                'type_id' => $appId,
                'group_name' => 'show'
            ],
            // Dashboard
            [
                'name' => 'view_dashboard',
                'type_id' => $appId,
                'group_name' => 'dashboard',
            ],
            [
                'name' => 'dashboard_card',
                'type_id' => $appId,
                'group_name' => 'dashboard',
            ],
            [
                'name' => 'payment_overview',
                'type_id' => $appId,
                'group_name' => 'dashboard',
            ],
            [
                'name' => 'yearly_overview',
                'type_id' => $appId,
                'group_name' => 'dashboard',
            ],

            // Clients
            [
                'name' => 'create_clients',
                'type_id' => $appId,
                'group_name' => 'clients',
            ],
            [
                'name' => 'view_clients',
                'type_id' => $appId,
                'group_name' => 'clients',
            ],
            [
                'name' => 'update_clients',
                'type_id' => $appId,
                'group_name' => 'clients',
            ],
            [
                'name' => 'delete_clients',
                'type_id' => $appId,
                'group_name' => 'clients',
            ],
            [
                'name' => 'client_invoice_details',
                'type_id' => $appId,
                'group_name' => 'clients',
            ],

            // Invoices
            [
                'name' => 'create_invoices',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'view_invoices',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'update_invoices',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'delete_invoices',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'invoice_download',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'invoice_checkout',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'invoice_send',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'invoice_resend',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],
            [
                'name' => 'delete_invoice_details_product',
                'type_id' => $appId,
                'group_name' => 'invoices',
            ],

            // Payments
            [
                'name' => 'create_payment_histories',
                'type_id' => $appId,
                'group_name' => 'payments',
            ],
            [
                'name' => 'view_payment_histories',
                'type_id' => $appId,
                'group_name' => 'payments',
            ],
            [
                'name' => 'update_payment_histories',
                'type_id' => $appId,
                'group_name' => 'payments',
            ],
            [
                'name' => 'delete_payment_histories',
                'type_id' => $appId,
                'group_name' => 'payments',
            ],

            // Products
            [
                'name' => 'create_products',
                'type_id' => $appId,
                'group_name' => 'products',
            ],
            [
                'name' => 'view_products',
                'type_id' => $appId,
                'group_name' => 'products',
            ],
            [
                'name' => 'update_products',
                'type_id' => $appId,
                'group_name' => 'products',
            ],
            [
                'name' => 'delete_products',
                'type_id' => $appId,
                'group_name' => 'products',
            ],

            // Category
            [
                'name' => 'create_categories',
                'type_id' => $appId,
                'group_name' => 'categories',
            ],
            [
                'name' => 'view_categories',
                'type_id' => $appId,
                'group_name' => 'categories',
            ],
            [
                'name' => 'update_categories',
                'type_id' => $appId,
                'group_name' => 'categories',
            ],
            [
                'name' => 'delete_categories',
                'type_id' => $appId,
                'group_name' => 'categories',
            ],

            // Expanse
            [
                'name' => 'view_expenses',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'create_expenses',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'update_expenses',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'delete_expenses',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],

            [
                'name' => 'view_purposes',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'create_purposes',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'update_purposes',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],
            [
                'name' => 'delete_purposes',
                'type_id' => $appId,
                'group_name' => 'expense',
            ],

            // Reports
            [
                'name' => 'payment_summary_reports',
                'type_id' => $appId,
                'group_name' => 'reports',
            ],
            [
                'name' => 'client_statement_report_reports',
                'type_id' => $appId,
                'group_name' => 'reports',
            ],
            [
                'name' => 'invoice_report_reports',
                'type_id' => $appId,
                'group_name' => 'reports',
            ],

            // User & Roles
            [
                'name' => 'view_users',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'invite_user',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'update_users',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'delete_users',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'attach_roles_users',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'detach_roles_users',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],

            // Role
            [
                'name' => 'view_roles',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'create_roles',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'update_roles',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'delete_roles',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],
            [
                'name' => 'attach_users_to_roles',
                'type_id' => $appId,
                'group_name' => 'user_and_roles',
            ],

            // Settings
            [
                'name' => 'view_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            // Email
            [
                'name' => 'view_delivery_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_delivery_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],

            // Payment
            [
                'name' => 'create_payment_method',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'view_payment_method',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_payment_method',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'delete_payment_method',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            //Notification
            [
                'name' => 'view_notification_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_notification_settings',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'view_notification_templates',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_notification_templates',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            //Invoice
            [
                'name' => 'manage_invoice_setting',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],

            //Tax
            [
                'name' => 'create_taxes',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'view_taxes',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'update_taxes',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'delete_taxes',
                'type_id' => $appId,
                'group_name' => 'settings',
            ],
            [
                'name' => 'view_updates',
                'type_id' => $appId,
                'group_name' => 'updates',
            ],
            [
                'name' => 'install_updates',
                'type_id' => $appId,
                'group_name' => 'updates',
            ],

        ];
        $this->enableForeignKeys();
        Permission::query()->insert($permissions);
    }
}
