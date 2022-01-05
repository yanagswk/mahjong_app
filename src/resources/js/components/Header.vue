<template>
    <!-- divタグがないとヘッダーの高さが固定されない -->
    <!-- <div> -->
    <header>
        <!-- ヘッダー -->
        <v-app-bar color="blue accent-4" dark>
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

            <RouterLink to="/" class="header-menu">
                <v-toolbar-title>麻雀 何キル？？？</v-toolbar-title>
            </RouterLink>

            <!-- 右寄せ -->
            <div class="flex-grow-1"></div>

            <v-tabs>
                <v-tab>アイテム1</v-tab>
                <v-tab>アイテム2</v-tab>
                <v-tab>アイテム3</v-tab>
            </v-tabs>

            <RouterLink to="/post_question" class="header-menu">
                <v-btn color="red" elevation="10">問題を投稿する</v-btn>
            </RouterLink>

            <RouterLink to="/login">
                <v-btn elevation="10" v-if="!isLogin">ログイン</v-btn>
            </RouterLink>

            <v-btn v-if="isLogin" elevation="10" @click="logout"
                >ログアウト
            </v-btn>

            <v-icon>mdi-account</v-icon>
            <span v-if="isLogin" style="white-space: nowrap">
                {{ username }}
            </span>
            <span v-else style="white-space: nowrap"> ゲストさん </span>

            <!-- <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn> -->

            <!-- <v-menu left bottom>
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        メニュー
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item v-for="n in 5" :key="n" @click="() => {}">
                        <v-list-item-title>りんく {{ n }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu> -->
        </v-app-bar>

        <!-- サイドメニュー -->
        <v-navigation-drawer v-model="drawer" fixed temporary>
                <v-list nav dense>
                    <v-list-item-group>
                        <v-list-item>
                            <v-list-item-title>HOME</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>ABOUT</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>WORK</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>SERVICE</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>BLOG</v-list-item-title>
                        </v-list-item>
                        <v-list-item>
                            <v-list-item-title>ACCESS</v-list-item-title>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </v-navigation-drawer>
        <!-- </div> -->
    </header>
    <!-- // <v-icon>mdi-open-in-new</v-icon> -->
</template>

<script>
import { mapState, mapGetters } from "vuex";

export default {
    data: () => ({
        drawer: false, // ハンバーガメニューフラグ
    }),
    computed: {
        ...mapState({
            apiStatus: (state) => state.auth.apiStatus,
        }),
        ...mapGetters({
            /**
             * ログインチェック
             * @return {boolean}
             */
            isLogin: "auth/check",
            /**
             * ログインしているユーザー名
             * @return {string}
             */
            username: "auth/username",
        }),
    },
    methods: {
        /**
         * ストアからログアウトAPI呼び出し
         */
        async logout() {
            await this.$store.dispatch("auth/logout");
            if (this.apiStatus) {
                // ログアウトメッセージ
                this.$store.dispatch("message/ADD_MESSAGES", {
                    content: "ログアウト",
                    color: "red",
                    timeout: "3000",
                });
                this.$router.push("/login");
            }
        },
    },
};
</script>

<style scoped>
.header-menu {
    text-decoration: none;
    color: gray;
    font-weight: bold;
}
.header-menu :hover {
    color: white;
}
</style>
