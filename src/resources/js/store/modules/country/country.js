import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    countryList: []
};

const getters = {
    getCountry: state => {
        return state.countryList
    }
};

const actions = {
    getCountry({commit}) {
        axiosGet('countries').then(({data}) => {
            commit('COUNTRY_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    COUNTRY_INFO(state, data) {
        state.countryList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
