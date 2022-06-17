import moment from "moment";
import optional from "./common/optional";

const settings = window.settings || {};

export const date_format = () => {
    return {
        'd-m-Y' : 'DD-MM-YYYY',
        'm-d-Y' : 'MM-DD-YYYY',
        'Y-m-d' : 'YYYY-MM-DD',
        'm/d/Y' : 'MM/DD/YYYY',
        'd/m/Y' : 'DD/MM/YYYY',
        'Y/m/d' : 'YYYY/MM/DD',
        'm.d.Y' : 'MM.DD.YYYY',
        'd.m.Y' : 'DD.MM.YYYY',
        'Y.m.d' : 'YYYY.MM.DD'
    };
};

export const getDateFormatForFrontend = (format) => {
    return date_format[format];
}

export const formatted_date = () => {
    return date_format()[optional(settings, 'date_format')] || date_format()['d-m-Y'];
};

export const serverDateFormat = 'YYYY-MM-DD';

export const getTimeFormatForFrontend = (format) => {
    const formates = {
        "h" : 12,
        "H" : 24
    }
    return formates[format];
}

export  const getTimeFromDateTime = (dateTime, timeFormat) =>{
    timeFormat = timeFormat == 12 ? 'h:mm a' : 'HH:mm';
    return moment(dateTime).format(timeFormat);
}

export  const  getDateFromNow = (date, format) => {
    return moment(date).calendar({
        sameDay: '[Today]',
        nextDay: '[Tomorrow]',
        nextWeek: 'dddd',
        lastDay: '[Yesterday]',
        lastWeek: '[Last] dddd',
        sameElse: format
    });
}

export const formatDateForServer = (date = null) => {
    if (!date) {
        return '';
    }

    moment.locale('en');
    return moment(moment(date), formatted_date()).format(serverDateFormat);
}
