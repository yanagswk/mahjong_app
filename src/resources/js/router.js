import Vue from "vue";
import VueRouter from "vue-router";

// ページコンポーネントをインポートする
import QuestionList from "./pages/QuestionList.vue";
import Login from "./pages/Login.vue";

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
];

// VueRouterインスタンスを作成する
const router = new VueRouter({
    // mode: 'history',
    routes,
});

// VueRouterインスタンスをエクスポートする
// app.jsでインポートするため
export default router;
