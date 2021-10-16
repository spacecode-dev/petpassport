export default {
    state: {
        counters: {}
    },
    getters: {

    },
    actions: {

    },
    mutations: {
        COUNTERS_UPDATE(state, counters) {
            state.counters = Object.assign({}, state.counters, counters);
        }
    }
}
