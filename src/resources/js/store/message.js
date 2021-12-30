// 個々のメッセージ識別するために使用
import { v4 as uuidv4 } from 'uuid';

const state = {
    // content: "",
    // flag: false,
    // timeout: "",
    messages: [],
};

const getters = {
    // メッセージが1つもない場合はSnackbarを表示しない
    isShow: (state) => state.messages.length !== 0,
    getMessages: (state) => state.messages,
};

const mutations = {
    // /**
    //  * メッセージ、表示時間設定
    //  * @param {string} content  メッセージ
    //  * @param {int}    timeout  表示時間
    //  */
    // setContent(state, { content, timeout }) {
    //     state.content = content;
    //     state.flag = true;
    //     if (typeof timeout === "undefined") {
    //         // TODO: 定数化
    //         state.timeout = 5000;
    //     } else {
    //         state.timeout = timeout;
    //     }
    //     // n秒後リセットする
    //     setTimeout(() => {
    //         state.message = "";
    //         state.flag = false;
    //     }, state.timeout);
    // },
    // /**
    //  * メッセージ削除
    //  */
    // deleteContent(state) {
    //     state.content = "";
    //     state.flag = false;
    // },
    /**
     *
     * @param {object} payload
     * content {string} メッセージ本文
     * color {string} メッセージ色
     * timeout {number} メッセージ本文
     */
    addMessages(state, payload) {
        const message = payload
        // 個々のメッセージが識別できるようにidを加える
        const messageObj = Object.assign(message, { id: uuidv4() })
        state.messages.push(messageObj);
    },

    /**
     *
     * @param {object} payload
     * id {number} メッセージid
     */
    removeMessage(state, payload) {
        const { id } = payload;
        state.messages.forEach((message, index) => {
            if (message.id === id) {
                state.messages.splice(index, 1);
            }
        });
    },
};

const actions = {
    /**
     * Snackbarにメッセージ(複数指定可)を表示する
     */
    ADD_MESSAGES({ commit }, payload) {
        commit("addMessages", payload);
    },

    /**
     * 指定したメッセージをSnackbarから削除する
     */
    REMOVE_MESSAGE({ commit }, payload) {
        commit("removeMessage", payload);
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
