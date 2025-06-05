export const overlapDate = {
    namespaced: true,
    state: {
        overlappedDates: {}
    },
    mutations: {
        overlappedDates(state, item) {
            state.overlappedDates = {};
            state.overlappedDates = item;
        }
    },
    getters: {
        overlappedDates: state => state.overlappedDates
    }
};