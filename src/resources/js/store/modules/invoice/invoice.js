import {axiosGet} from "../../../app/Helpers/AxiosHelper";


const state = {
    invoiceList: []
};

const getters = {
    getInvoice: state => {
        return state.invoiceList
    }
};

const actions = {
    getInvoice({commit}) {
        axiosGet('all-invoice').then(({data}) => {
            commit('INVOICE_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    INVOICE_INFO(state, data) {
        state.invoiceList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
