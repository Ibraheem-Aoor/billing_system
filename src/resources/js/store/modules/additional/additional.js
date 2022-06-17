import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    clientUserList: [],
    currencyList: [],
    purposeList:[],
};

const getters = {
    getClientUser: state => {
        return state.clientUserList
    },
    getCurrency: state => {
        return state.currencyList
    },
    getPurpose: state => {
        return state.purposeList
    }
};

const actions = {
    getClientUser({commit}) {
        axiosGet('client-users').then(({data}) => {
            commit('CLIENT_USER_INFO', data)
        }).catch((error) => console.log(error));
    },
    getCurrency({commit}) {
        axiosGet('all-currency').then(({data}) => {
            commit('CURRENCY_INFO', data)
        }).catch((error) => console.log(error));
    },
    getPurpose({commit}, paylod) {
        axiosGet(`purpose-list?type=${paylod}`).then(({data}) => {
            commit('PURPOSE_LIST', data)
        }).catch((error) => console.log(error));
    }
};

const mutations = {
    CLIENT_USER_INFO(state, data) {
        state.clientUserList = data;
    },
    CURRENCY_INFO(state, data) {
        state.currencyList = data;
    },
    PURPOSE_LIST(state, data) {
        state.purposeList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
