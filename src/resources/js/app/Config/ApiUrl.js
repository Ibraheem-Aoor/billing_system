import {urlGenerator} from "../Helpers/AxiosHelper";

export const NOTIFICATION_EVENTS = '/admin/app/notification-events';
export const NOTIFICATION_TEMPLATES = '/admin/app/notification-templates';
export const NOTIFICATION_EVENT_SETTINGS = 'admin/notification-events/settings/';
//Dashboard
export const DEFAULT_INFO = 'default-info';
export const DEFAULT_ACADEMIC_INFO = 'default-academic-info';
export const DEFAULT_DASHBOARD_INFO = 'default-dashboard-info';
export const AVAILABLE_COURSE_LIST = 'available-course-list';
export const STUDENT_OVERVIEW = 'student-overview';
export const SCHOOL_OVERVIEW = 'school-overview';
export const INSTRUCTOR_STUDENT_OVERVIEW = 'instructor-student-overview';
export const AUDIENCE_OVERVIEW_CHART = 'audience-overview-chart';
export const BROWSER_OVERVIEW_CHART = 'browser-overview-chart';
export const BUSINESS_OVERVIEW = 'business-overview';
export const CONTACT_OVERVIEW = 'contact-overview';
export const TEAM_OVERVIEW = 'team-overview';
export const DOCTORS_LIST = 'doctors-list';
export const UPCOMING_APPOINTMENTS = 'upcoming-appointments';
export const DEFAULT_HOSPITAL_INFO = 'default-hospital-info';
export const HOSPITAL_ACTIVITIES = 'hospital-activities';
export const PATIENT_STATISTICS = 'patient-statistics';
export const HRM_BASIC_DATA = 'hrm-basic-data';
export const PROJECT_OVERVIEW = 'project-overview';
export const YEARLY_HOLIDAY = 'yearly-holiday';
export const EMPLOYEE_OVERVIEW = 'employee-overview';

//Sample pages
export const REPORTS = 'reports';
export const CALENDARS = 'calendars';
export const STAGES = 'stages';
export const TASKS = 'tasks';

//Profile
export const MY_PROFILE = '/my-profile';
export const All_NOTIFICATION = '/all-notifications';
export const LOGOUT = '/admin/log-out';

//app setting view
export const APP_SETTINGS = '/app-setting';
export const GENERAL_SETTINGS = 'general-settings';

//reCAPTCHA
export const GET_RECAPTCHA_SETTINGS = '/get-re-captcha-setting';
//Sms settings
export const GET_SMS_SETTINGS_INFO = 'get-sms-setting-info';
//Email settings
export const GET_EMAIL_SETTINGS = '/admin/app/settings/delivery-settings';

//DataTable
export const DATATABLE_DATA = 'crud';
export const DATATABLE_SEARCH_SELECT = '/datatable/name';

//roles and users
export const ROLES = 'admin/auth/roles';
export const SYSTEMROLES = 'system-roles';
export const BILLARUSERS = 'billar/user-delete';
export const USERS = 'admin/auth/users';
export const USERS_LIST = 'user-list';
export const ALL_USERS = 'all-users';
export const GET_USERS = 'get/users';
export const GET_STATUSES = 'admin/app/statuses';
export const INVITE_USER = '/admin/auth/users/invite-user';
export const DETACH_ROLES = 'admin/auth/users/detach-roles/';
export const UPDATE_USER_NAME = '/update-user-name/';

//Notification
export const NOTIFICATIONS = '/admin/user/notifications';
export const AUTHENTICATE_USER = '/admin/authenticate-user';
export const LOGIN_USER = '/login-user';

// Language
export const LANGUAGE = 'languages';
export const BASIC_SETTINGS = '/get-basic-setting-data';

// Social links
export const CHANGE_SOCIAL_LINKS = '/change-social-link';

//Payment Methods
export const PAYMENT_METHOD = '/payment-method';
export const GET_PAYMENT_METHOD_STATUS = '/payment-method-status';
export const GET_STRIPE_STATUS = '/stripe-status';

//Reports
export const PAYMENT_SUMMARY_REPORT = '/reports/payment-summary';
export const INVOICE_REPORT = '/reports/invoice-report';
export const CLIENT_STATEMENT_REPORT = '/reports/client-statement-report';


//Update
export const APP_UPDATE = 'app/updates';
export const APP_UPDATE_INSTALL = 'app/updates/install';

//Install
export const APP_LOG_IN = 'admin/users/login';
export const APP_INSTALL_ADMIN_INFO = 'setup/admin-info';
export const GENERATE_PURCHASE_CODE_URL = 'setup/generate-url';
export const GET_DATABASE_HOSTNAME = 'setup/get-database-hostname';
export const GET_UPDATE_URL = 'app/generated-update-url-purchase-code';
export const SET_UP_EMAIL ='setup/email-setup';
export const SET_UP_BROADCAST = 'setup/broadcast-setup';
export const BROADCAST_SETTING_UPDATE = 'setup/broadcast-setting-update';
export const BROADCAST_SKIP = 'setup/broadcast-skip';
export const EMAIL_SETUP_SKIP = 'setup/email-setup-skip';
export const ADDITIONAL_REQUIREMENTS = 'setup/additional-requirements';
export const ADDITIONAL_REQUIREMENT = 'setup/additional-requirement';
export const DATABASE_CONFIGURATION = 'setup/database';
export const PURCHASE_CODE= 'setup/purchase-code';
export const PURCHASE_CODE_STORE= 'setup/purchase-code-store';
export const INSTALL= 'install';
export const EMAIL_SETTING_UPDATE= 'setup/email-setting-update-delivery';
export const TEST_MAIL= 'app/test-mail/send';
export const CLEAR_CACHE= 'app/clear-cache';