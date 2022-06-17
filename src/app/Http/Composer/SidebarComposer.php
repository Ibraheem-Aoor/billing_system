<?php

namespace App\Http\Composer;

use Illuminate\View\View;

class SidebarComposer
{
    public function compose(View $view)
    {
        $view->with(['data' => [
            [
                'icon' => 'pie-chart',
                'name' => trans('default.dashboard'),
                'url' => request()->root() . '/admin/dashboard',
                'permission' => auth()->user()->can('view_dashboard'),
            ],
            [
                'icon' => 'users',
                'name' => trans('default.clients'),
                'url' => request()->root() . '/clients/list/view',
                'permission' => auth()->user()->can('view_clients'),
            ],
            [
                'icon' => 'file-text',
                'name' => trans('default.invoices'),
                'url' => request()->root() . '/invoices/list/view',
                'permission' => auth()->user()->can('view_invoices'),
            ],
            [
                'icon' => 'credit-card',
                'name' => trans('default.payments'),
                'url' => request()->root() . '/payment/list/view',
                'permission' => auth()->user()->can('view_payment_histories'),
            ],
            [
                'name' => trans('default.products'),
                'id' => 'products',
                'icon' => 'box',
                'permission' => authorize_any(['view_products', 'view_categories']),
                'subMenu' => [
                    [
                        'name' => trans('default.product_list'),
                        'url' => request()->root() . '/products/list/view',
                        'permission' => auth()->user()->can('view_products'),
                    ],
                    [
                        'name' => trans('default.categories'),
                        'url' => request()->root() . '/categories/list/view',
                        'permission' => auth()->user()->can('view_categories'),
                    ],
                ]
            ],
            [
                'name' => trans('default.expenses'),
                'id' => 'expenses',
                'icon' => 'minus-circle',
                'permission' => authorize_any(['view_expenses', 'view_purposes']),
                'subMenu' => [
                    [
                        'name' => trans('default.expenses_list'),
                        'url' => request()->root() . '/expenses/list/view',
                        'permission' => auth()->user()->can('view_expenses'),
                    ],
                    [
                        'name' => trans('default.purposes'),
                        'url' => request()->root() . '/purposes/list/view',
                        'permission' => auth()->user()->can('view_purposes'),
                    ],
                ]
            ],
            [
                'name' => trans('default.reports'),
                'id' => 'reports',
                'icon' => 'bar-chart-2',
                'permission' => authorize_any([
                    'payment_summary_reports',
                    'client_statement_report_reports',
                    'invoice_report_reports'
                ]),
                'subMenu' => [
                    [
                        'name' => trans('default.payments_summary'),
                        'url' => request()->root() . '/payment-summary',
                        'permission' => auth()->user()->can('payment_summary_reports'),
                    ],
                    [
                        'name' => trans('default.client_statement'),
                        'url' => request()->root() . '/client-statement',
                        'permission' => auth()->user()->can('client_statement_report_reports'),
                    ],
                    [
                        'name' => trans('default.invoice_report'),
                        'url' => request()->root() . '/invoice-report',
                        'permission' => auth()->user()->can('invoice_report_reports'),
                    ],
                ],
            ],
            [
                'icon' => 'user-check',
                'name' => trans('custom.user_and_roles'),
                'url' => request()->root() . '/users-and-roles',
                'permission' => authorize_any(['view_users', 'view_roles']),
            ],
            [
                'icon' => 'settings',
                'name' => trans('custom.settings'),
                'url' => request()->root() . '/app-setting',
                'permission' => authorize_any(
                    [
                        'view_settings', 'update_settings', 'view_delivery_settings',
                        'update_delivery_settings',
                        'view_sms_settings', 'update_sms_settings',
                        'view_recaptcha_settings',
                        'view_payment_method',
                        'update_payment_method',
                        'delete_payment_method',
                        'view_notification_settings',
                        'update_notification_settings',
                        'update_notification_templates',
                        'view_notification_templates',
                    ]
                ),
            ],
        ]]);
    }
}
