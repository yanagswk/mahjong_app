const state = {
    user: null      // ログイン済みユーザー
};

const getters = {};

const mutations = {
    setUser(state, user) {
        state.user = user;
    }
};

const actions = {
    /**
     * 会員登録API
     * @method POST
     * @param {object} data 登録データ
     */
    async register(context, data) {
        const response = await axios.post('/api/register', data);
        context.commit('setUser', response.data);
    },

    /**
     * ログインAPI
     * @method POST
     * @param {object} data ログインデータ
     */
    async login(context, data) {
        const response = await axios.post('/api/login', data);
        context.commit('setUser', response.data);
    },

    /**
     * ログアウトAPI
     */
    async logout(context) {
        const response = await axios.post('api/logout');
        context.commit('setUser', null);
    }
};

export default {
    namespaced: true,   // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions,
};
