const state = {
    loading: true, //true:ローディングを表示, false:ローディング非表示
};

const getters = {
    loading: (state) => (state.loading ? state.loading : ""),
};

const mutations = {
    setLoading(state, loading) {
        state.loading = loading;
    },
};
const actions = {
    async startLoad(context) {
        context.commit("setLoading", true);
    },
    async endLoad(context) {
        context.commit("setLoading", false);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
