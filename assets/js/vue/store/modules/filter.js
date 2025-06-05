export const filter = {
    namespaced: true,
    state: {
        count: 0,
        search: '',
        items: [],
        columns: []
    },
    mutations: {
        count(state, count) {
            state.count = count;
        },
        search(state, search) {
            state.search = search;
        },
        items(state, item) {
            state.items = [];
            state.items = item;
        },
        columns(state, item) {
            state.columns = [];
            state.columns = item;
        }
    },
    getters: {
        count: state => state.count,
        search: state => state.search,
        items: state => state.items,
        columns: state => state.columns
    }
};