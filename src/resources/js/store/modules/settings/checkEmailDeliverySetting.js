import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    checkEmail: null
}

const getters = {
    checkEmailDelivery: state => state.checkEmail,
}

const mutations = {
    CHECK_EMAIL_DELIVERY_SETTING(state, data) {
        state.checkEmail = data
    },
}

const actions = {
    checkEmailDelivery({commit}) {
        axiosGet('check-mail-delivery-setting').then(({data}) => {
            commit('CHECK_EMAIL_DELIVERY_SETTING', data);
        })
    }
}

export default {
    state,
    getters,
    actions,
    mutations
}
