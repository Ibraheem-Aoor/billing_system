import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    categoryList: []
};

const getters = {
    getCategory: state => {
        return state.categoryList
    }
};

const actions = {
    getCategory({commit}) {
        axiosGet('all-category').then(({data}) => {
            commit('CATEGORY_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    CATEGORY_INFO(state, data) {
        state.categoryList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
