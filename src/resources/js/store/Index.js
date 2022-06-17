import settings from './modules/settings/Settings';
import user from './modules/user/User';
import theme from './modules/theme/Theme';
import userAndRoles from './modules/user/UserRoles';
import notificationSettings from './modules/settings/NotificationSettings';
import category from './modules/category/category';
import country from './modules/country/country';
import status from './modules/status/status';
import recurring from './modules/recurring/recurringCycle';
import invoice from "./modules/invoice/invoice";
import paymentMethod from "./modules/paymentMethod/paymentMethod";
import tax from "./modules/tax/taxes";
import clientUser from "./modules/additional/additional";
import checkEmailSetting from "./modules/settings/checkEmailDeliverySetting";

export default {
    modules: {
        theme,
        settings,
        user,
        userAndRoles,
        notificationSettings,
        category,
        country,
        status,
        recurring,
        invoice,
        paymentMethod,
        tax,
        clientUser,
        checkEmailSetting
    }
}
