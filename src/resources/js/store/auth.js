const state = {
    user: null      // ログイン済みユーザー
};

const getters = {
    check: state => !! state.user,
    username: state => state.user ? state.user.name : ''
};

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
     * @method POST
     */
    async logout(context) {
        const response = await axios.post('/api/logout');
        context.commit('setUser', null);
    },

    /**
     * ログインユーザー取得API
     * @method GET
     */
    async currentUser(context) {
        const response = await axios.get('/api/user');
        const user = response.data || null;
        context.commit('setUser', user);
    }
};

export default {
    namespaced: true,   // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions,
};
