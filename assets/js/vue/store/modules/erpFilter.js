export const erpFilter = {
    namespaced: true,
    state: {
        count: 0,
        filters: {},
        items: [],
        selected: []
    },
    mutations: {
        count(state, count) {
            state.count = count
        },
        filters(state, data) {
            if (data) {
                state.filters = Object.assign({}, data)
            }
        },
        items(state, data) {
            if (data) {
                state.items = Object.assign({}, data)
            }
        },
        select(state, selection) {
            if (selection) {
                state.selected = selection
            }
        }
    },
    actions: {
        async saveItems({ commit }, data) {
            if (data) {
                commit('items', data)
            }
        },
        async saveFilters({ commit }, data) {
            if (data) {
                commit('filters', data)
            }
        },
        async removeFilters({ commit }) {
            commit('filters', {})
        }
    },
    getters: {
        getCount(state) {
            return state.count
        },
        getFilters(state) {
            return state.filters
        },
        convertToQuery(state) {
            const query = Object.keys(state.filters)
                .map((key, index) => {
                    if (Array.isArray(state.filters[key])) {
                        return `${index === 0 ? '?' : ''}${key}=${JSON.stringify(state.filters[key])}`;
                    } else {
                        return `${index === 0 ? '?' : ''}${key}=${state.filters[key]}`;
                    }
                })
                .join("&");
            return query;
        }
    }
};