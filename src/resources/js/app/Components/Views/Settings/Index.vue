<template>
    <div class="content-wrapper">
        <app-breadcrumb :page-title="pageTitle" :icon="pageIcon"/>
        <app-tab :tabs="tabs" :icon="pageIcon"/>
    </div>
</template>

<script>
export default {
    name: "SettingsLayout",
    data() {
        return {
            pageTitle: 'Settings',
            pageIcon: 'settings',
            tabs: [
                {
                    'name': this.$t('general'),
                    'title': this.$t('general'),
                    'component': 'general-setting',
                    'permission': this.$can('view_settings') ? true : false,
                },
	            {
                    'name': this.$t('cron_job'),
                    'title': this.$t('cron_job'),
                    'component': 'cron-job',
                    'permission': true,
                },
                {
                    'name': this.$t('email_setup'),
                    'title': this.$t('email_setup'),
                    'component': 'email-setting',
                    'permission': this.$can('view_delivery_settings') ? true : false
                },
                {
                    'name': this.$t('payment_methods'),
                    'title': this.$t('payment_methods'),
                    'component': 'payment-method',
                    'permission': this.$can('view_payment_method') ? true : false,

                    'headerButton': this.$can('create_payment_method') ? {
                        'label': this.$t('add_payment_method'),
                        'class': 'btn btn-primary'
                    } : {}
                },
                {
                    'name': this.$t('notification'),
                    'title': this.$t('notification'),
                    'component': 'notification-settings',
                    'permission': this.$can('update_notification_templates') ? true : false,
                },
                {
                    'name': this.$t('invoice'),
                    'title': this.$t('invoice'),
                    'component': 'invoice-setting',
                    'permission': this.$can('manage_invoice_setting') ? true : false,
                },
                {
                    'name': this.$t('tax'),
                    'title': this.$t('tax'),
                    'component': 'tax-setting',
                    'permission': this.$can('view_taxes') ? true : false,
                    headerButton: this.$can('create_taxes') ? {
                        label: this.$t('add_tax'),
                        class: 'btn btn-primary'
                    } : {}
                },
                {
                    name: this.$t('update'),
                    title: this.$t('update'),
                    component: "app-update",
                    permission: this.$can('view_updates') ? true : false,
                },
            ]
        }
    },
}
</script>
