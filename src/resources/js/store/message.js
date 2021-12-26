const state = {
    content: "",
    flag: false,
    timeout: ""
};

const mutations = {
    /**
     * メッセージ、表示時間設定
     * @param {string} content  メッセージ
     * @param {int}    timeout  表示時間
     */
    setContent(state, {content, timeout}) {
        console.log(content, timeout)
        state.content = content;
        state.flag = true;
        if (typeof timeout === "undefined") {
            // TODO: 定数化
            state.timeout = 5000;
        } else {
            state.timeout = timeout;
        }
        // n秒後リセットする
        setTimeout(() => {
            state.message = ""
            state.flag = false
        }, state.timeout);
    },
    /**
     * メッセージ削除
     */
    deleteContent(state) {
        state.content = "";
        state.flag = false;
    }
};

// const actions = {
//     setMessage
// };

export default {
    namespaced: true,
    state,
    mutations,
};
