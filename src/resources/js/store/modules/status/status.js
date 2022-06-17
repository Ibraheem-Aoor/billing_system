import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    statusList: [],
    invoiceStatusList: [],

};

const getters = {
    getStatus: state => state.statusList,
    getInvoiceStatus: state => state.invoiceStatusList,
};
const mutations = {
    STATUS_INFO(state, data) {
        state.statusList = data;
    },
    INVOICE_STATUS_INFO(state, data) {
        state.invoiceStatusList = data;
    },
};

const actions = {
    getStatus({commit}) {
        axiosGet('admin/app/statuses').then(response => {
            commit('STATUS_INFO', response.data)
        }).catch((error) => console.log(error));
    },
    getInvoiceStatus({commit}) {
        axiosGet('admin/app/statuses?type=invoice').then(response => {
            commit('INVOICE_STATUS_INFO', response.data)
        }).catch((error) => console.log(error));
    },
};


export default {
    state,
    getters,
    actions,
    mutations
}
