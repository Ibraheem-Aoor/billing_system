import {axiosGet} from "../../../app/Helpers/AxiosHelper";


const state = {
    paymentMethodList: []
};

const getters = {
    getPaymentMethod: state => {
        return state.paymentMethodList
    }
};

const actions = {
    getPaymentMethod({commit}) {
        axiosGet('all-payment-method').then(({data}) => {
            commit('PAYMENT_METHOD_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    PAYMENT_METHOD_INFO(state, data) {
        state.paymentMethodList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
