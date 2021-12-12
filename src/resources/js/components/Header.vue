<template>
    <!-- divタグがないとヘッダーの高さが固定されない -->
    <div>
    <!-- ヘッダー -->
        <v-app-bar color="pink accent-4" dark>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <RouterLink to="/">
                <v-btn>
                    <v-toolbar-title>麻雀 何キル？？？</v-toolbar-title>
                </v-btn>
            </RouterLink>

            <div class="flex-grow-1"></div>

            <RouterLink to="/post_question">
                <v-btn color="red" elevation="10">問題を投稿する</v-btn>
            </RouterLink>

            <RouterLink to="/login">
                <v-btn elevation="10">ログイン</v-btn>
            </RouterLink>

            <v-btn
                v-if="isLogin"
                elevation="10"
                @click="logout"
                >ログアウト
            </v-btn>

            <span v-if="isLogin">
                {{ username }}
            </span>

            <v-btn icon>
                <v-icon>mdi-heart</v-icon>
            </v-btn>

            <v-btn icon>
                <v-icon>mdi-magnify</v-icon>
            </v-btn>

            <v-menu left bottom>
                <!-- v-slot:activator : 特定の条件時(クリック時・ホバー時のみなど）のみポップアップする場合のトリガー用のスロット -->
                <template v-slot:activator="{ on }">
                    <v-btn icon v-on="on">
                        <v-icon>mdi-dots-vertical</v-icon>
                    </v-btn>
                </template>

                <v-list>
                    <v-list-item v-for="n in 5" :key="n" @click="() => {}">
                        <v-list-item-title>りんく {{ n }}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>
        </v-app-bar>
    </div>
    <!-- // <v-icon>mdi-open-in-new</v-icon> -->
</template>

<script>
export default {
    computed: {
        /**
         * ログインチェック
         */
        isLogin() {
            return this.$store.getters['auth/check'];
        },
        /**
         * ログインユーザー取得
         */
        username() {
            return this.$store.getters['auth/username']
        }
    },
    methods: {
        /**
         * ストアからログアウトAPI呼び出し
         */
        async logout() {
            await this.$store.dispatch('auth/logout');
            this.$router.push("/");
        }
    }
}
</script>
