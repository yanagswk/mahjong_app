import { OK, CREATED, UNPROCESSABLE_ENTITY } from "../until";

const state = {
    user: null, // ログイン済みユーザー
    apiStatus: null, // apiの呼び出しが成功したかの判定
    loginErrorMessages: null, // ログインエラーメッセージ
    registerErrorMessages: null, // 登録エラーメッセージ
};

const getters = {
    check: (state) => !!state.user,
    username: (state) => (state.user ? state.user.name : ""),
};

const mutations = {
    /**
     * ログイン済みユーザー更新
     * @param {string} user
     */
    setUser(state, user) {
        state.user = user;
    },
    /**
     * api判定更新
     * @param {boolean} status
     */
    setApiStatus(state, status) {
        state.apiStatus = status;
    },
    /**
     * ログインエラーメッセージ更新
     * @param {string} messages
     */
    setLoginErrorMessages(state, messages) {
        state.loginErrorMessages = messages;
    },
    /**
     * 登録エラーメッセージ更新
     * @param {string} messages
     */
    setRegisterErrorMessages(state, messages) {
        state.registerErrorMessages = messages;
    },
};

const actions = {
    /**
     * 会員登録API
     * @method POST
     * @param {object} data 登録データ
     */
    async register(context, data) {
        context.commit("setApiStatus", null);
        const response = await axios.post("/api/register", data);

        // ステータスが201の時はユーザー情報をストアに保存して終了
        if (response.status === CREATED) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);
            return false;
        }

        context.commit("setApiStatus", false);
        // バリデーションエラーの場合
        if (response.status === UNPROCESSABLE_ENTITY) {
            context.commit("setRegisterErrorMessages", response.data.errors);
        } else {
            context.commit("error/setCode", response.status, { root: true });
        }
    },

    /**
     * ログインAPI
     * @method POST
     * @param {object} data ログインデータ
     */
    async login(context, data) {
        context.commit("setApiStatus", null);
        // 非同期処理が成功した場合も失敗した場合も同じ変数に代入できる
        const response = await axios.post("/api/login", data);
        // .catch(err => err.response || err);

        // ステータスが200の時はユーザー情報をストアに保存して終了
        if (response.status === OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);
            return false;
        }

        context.commit("setApiStatus", false);
        // バリデーションエラーの場合
        if (response.status === UNPROCESSABLE_ENTITY) {
            console.log(response.data.errors);
            context.commit("setLoginErrorMessages", response.data.errors);
        } else {
            // 別のモジュールのミューテーションをcommitする場合は第三引数に{root:true}を追加する
            context.commit("error/setCode", response.status, { root: true });
        }
    },

    /**
     * ログアウトAPI
     * @method POST
     */
    async logout(context) {
        context.commit("setApiStatus", null);
        const response = await axios.post("/api/logout");

        if (response.status === OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", null);
            return false;
        }

        context.commit("setApiStatus", false);
        context.commit("error/setCode", response.status, { root: true });
    },

    /**
     * ログインユーザー取得API
     * @method GET
     */
    async currentUser(context) {
        context.commit("setApiStatus", null);
        const response = await axios.get("/api/user");
        const user = response.data || null;

        if (response.status === OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", user);
            return false;
        }

        context.commit("setApiStatus", false);
        context.commit("error/setCode", response.status, { root: true });
    },
};

export default {
    namespaced: true, // 名前空間を有効にする
    state,
    getters,
    mutations,
    actions,
};
