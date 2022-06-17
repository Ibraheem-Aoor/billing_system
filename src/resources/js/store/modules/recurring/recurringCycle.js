import {axiosGet} from "../../../app/Helpers/AxiosHelper";

const state = {
    recurringCList: []
};

const getters = {
    getRecurringCycle: state => {
        return state.recurringCList
    }
};

const actions = {
    getRecurringCycle({commit}) {
        axiosGet('/recurring-cycle').then(({data}) => {
            commit('RECURRING_CYCLE_INFO', data)
        }).catch((error) => console.log(error));
    },
};

const mutations = {
    RECURRING_CYCLE_INFO(state, data) {
        state.recurringCList = data;
    }
};


export default {
    state,
    getters,
    actions,
    mutations
}
