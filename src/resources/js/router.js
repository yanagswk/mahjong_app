import Vue from "vue";
import VueRouter from "vue-router";

import QuestionList from "./pages/QuestionList.vue";
import Login from "./pages/Login.vue";
import PostQuestion from "./pages/PostQuestion.vue";
import QuestionAnswer from "./pages/QuestionAnswer.vue";
import SystemError from './pages/errors/System.vue'

import store from './store';

// VueRouterプラグインを使用する
// これによって<RouterView />コンポーネントなどを使うことができる
Vue.use(VueRouter);

// パスとコンポーネントのマッピング
const routes = [
    {
        path: "/",
        component: QuestionList,
    },
    {
        path: "/login",
        component: Login,
        beforeEnter(to, from, next) {
            // ログインしてたら一覧画面へ
            if (store.getters['auth/check']) {
                next('/');
            } else {
                next();
            }
        }
    },
    {
        path: "/post_question",
        component: PostQuestion,
        beforeEnter(to, from, next) {
            // ログインしていなかったらログイン画面へ
            if (!store.getters['auth/check']) {
                store.dispatch('message/ADD_MESSAGES', {
                    content: "問題を投稿するにはログインが必要です",
                    color: "red",
                    timeout: "3000"
                });
                next('/login');
            } else {
                next();
            }
        }
    },
    {
        path: "/question_answer/:id",
        component: QuestionAnswer,
        props: true
    },
    {
        path: '/500',
        component: SystemError
    }
];

// VueRouterインスタンスを作成する
const router = new VueRouter({
    // mode: 'history',
    routes,
});

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router;

