import Vue from "vue";
import VueRouter from "vue-router";

import QuestionList from "./pages/QuestionList.vue";
import Login from "./pages/Login.vue";
import PostQuestion from "./pages/PostQuestion.vue";
import QuestionAnswer from "./pages/QuestionAnswer.vue";

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
    },
    {
        path: "/post_question",
        component: PostQuestion
    },
    {
        path: "/question_answer/:id",
        component: QuestionAnswer,
        props: true
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

// http://127.0.0.1:80/storage/five_sou.png
