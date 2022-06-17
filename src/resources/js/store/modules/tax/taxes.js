import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    taxList: []
};

const getters = {
    getTax: state => {
        return state.taxList
    }
};

const actions = {
    getTax({commit}) {
        axiosGet('all-taxes').then(({data}) => {
            commit('TAX_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    TAX_INFO(state, data) {
        state.taxList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
