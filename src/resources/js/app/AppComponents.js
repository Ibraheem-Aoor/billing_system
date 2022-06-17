import Vue from 'vue';

// Helpers Component
import './Components/Helpers/HelperComponent';

/**
 * All Component of Billar
 */
Vue.component('personal-information', require('./Components/Views/Auth/PersonalInformation').default);
Vue.component('password-change', require('./Components/Views/Auth/PasswordChange').default);
Vue.component('social-links', require('./Components/Views/Auth/SocialLinks').default);
Vue.component('login', require('./Components/Views/Auth/Login').default);
Vue.component('password-reset', require('./Components/Views/Auth/PasswordReset').default);
Vue.component('reset-password', require('./Components/Views/Auth/ResetPassword').default);
Vue.component('registration', require('./Components/Views/Auth/Registration').default);
Vue.component('re-captcha', require('./Components/Views/Auth/ReCaptcha').default);
Vue.component('my-profile', require('./Components/Views/Auth/Profile').default);

// Settings
Vue.component('app-setting', require('./Components/Views/Settings/Index').default);
Vue.component('general-setting', require('./Components/Views/Settings/GeneralSetting').default);
Vue.component('email-setting', require('./Components/Views/Settings/EmailSetting').default);
Vue.component('sms-setting', require('./Components/Views/Settings/SmsSetting').default);
Vue.component('google-re-captcha-setting', require('./Components/Views/Settings/GoogleRecaptchaSetting').default);
Vue.component('notification-settings', require('./Components/Views/Settings/Notification/Settings/Index').default);
Vue.component('database-template', require('./Components/Views/Settings/Notification/Template/DatabaseTemplate').default);
Vue.component('mail-template', require('./Components/Views/Settings/Notification/Template/MailTemplate').default);
Vue.component('payment-method', require('./Components/Views/Settings/PaymentMethod/PaymentMethod').default);
Vue.component('invoice-setting', require('./Components/Views/Settings/InvoiceSetting').default);
Vue.component('tax-setting', require('./Components/Views/Settings/Tax/Index').default);
Vue.component('tax-add-edit-modal', require('./Components/Views/Settings/Tax/TaxAddEditModal').default);

// Cron job

Vue.component('cron-job', require('./Components/Views/Settings/CronJob/CronJobSettings').default);

Vue.component('payment-method-create-edit-modal', require('./Components/Views/Settings/PaymentMethod/PaymentMethodCreateEditModal').default);
// User and Roles
Vue.component('user-roles', require('./Components/Views/UserRoles/Index').default);

Vue.component('group-of-users', require('./Components/Views/UserRoles/Roles/GroupOfUsers').default);
// Layouts
Vue.component('app-top-bar', require('./Components/Views/Layouts/Nabar').default);

Vue.component('app-sidebar', require('./Components/Views/Layouts/Sidebar').default);

// Notifications
Vue.component('all-notification', require('./Components/Views/Auth/Notification').default);

// Dashboard
Vue.component('dashboard', require('./Components/Views/Dashboard/Index').default);

// Clients
Vue.component('clients', require('./Components/Views/Clients/Index').default);
Vue.component('client-details', require('./Components/Views/Clients/ClientDetails').default);
Vue.component('client-add-edit-modal', require('./Components/Views/Clients/ClientAddEditModal').default);
Vue.component('client-address-column', require('./Components/Views/Clients/AddressColumn').default);
Vue.component('client-email-column', require('./Components/Views/Clients/EmailColumn').default);
Vue.component('client-phone-column', require('./Components/Views/Clients/PhoneColumn').default);
Vue.component('address-view-all-modal', require('./Components/Views/Clients/AddressViewAllModal').default);

// Invoices
Vue.component('invoices', require('./Components/Views/Invoices/Index').default);
Vue.component('invoice-details', require('./Components/Views/Invoices/InvoiceDetails').default);
Vue.component('send-invoice-modal', require('./Components/Views/Invoices/SendInvoiceModal').default);
Vue.component('invoice-add-edit-modal', require('./Components/Views/Invoices/InvoiceAddEditModal').default);
Vue.component('invoice-payment-modal', require('./Components/Views/Invoices/InvoicePaymentModal').default);
Vue.component('stripe-checkout-modal', require('./Components/Views/Invoices/StripeCheckout').default);

// Payments
Vue.component('payments', require('./Components/Views/Payments/Index').default);
Vue.component('payment-add-edit-modal', require('./Components/Views/Payments/PaymentAddEditModal').default);

// Products
Vue.component('products', require('./Components/Views/Products/Index').default);
Vue.component('product-add-edit-modal', require('./Components/Views/Products/ProductAddEditModal').default);
Vue.component('categories', require('./Components/Views/Products/Categories').default);
Vue.component('category-add-edit-modal', require('./Components/Views/Products/CategoryAddEditModal').default);

// Reports
Vue.component('general-summary-report', require('./Components/Views/Reports/GeneralSummaryReport').default);
Vue.component('payment-summary-report', require('./Components/Views/Reports/PaymentSummaryReport').default);
Vue.component('client-statement-report', require('./Components/Views/Reports/ClientStatementReport').default);
Vue.component('invoice-report', require('./Components/Views/Reports/InvoiceReport').default);
Vue.component('expense-report', require('./Components/Views/Reports/ExpenseReport').default);

//Helpers
Vue.component('app-media-column', require('./Components/Helpers/MediaColumn').default);

//installer
Vue.component('app-environment-wizard', require('./Components/Views/Install/Env/Environment').default)

//Update

Vue.component('app-update', require('./Components/Views/Settings/Update/template/Update').default);
Vue.component('app-manual-updater', require('./Components/Views/Settings/Update/template/ManualUpdater').default);
Vue.component('app-update-confirmation-modal', require('./Components/Views/Settings/Update/template/UpdateConfirmationModal').default);
//Expense
Vue.component('app-expense', require('./Components/Views/Expense/Expense').default);
Vue.component('app-expense-create-edit-modal', require('./Components/Views/Expense/ExpenseCreateEditModal').default);
Vue.component('app-attachments-column', require('./Components/Helpers/AttachmentsColumn').default);

//purposes
Vue.component('app-purposes', require('./Components/Views/Purposes/Purpose').default);
Vue.component('app-purpose-add-edit-modal', require('./Components/Views/Purposes/PurposeAddEditModal').default);

