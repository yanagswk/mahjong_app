<template>
    <!-- https://kumatetsublog.com/shoot/blog/laravel-vuetify-login -->
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row align="center" justify="center">
                    <!-- <v-col cols="12" sm="8" md="4"> -->
                    <v-card elevation="5" width="600px" class="mx-auto mt-5">
                        <v-toolbar color="primary" dark flat>
                            <v-toolbar-title>
                                <v-btn @click="tab = 1">ログイン </v-btn>
                            </v-toolbar-title>
                            <v-toolbar-title>
                                <v-btn @click="tab = 2">登録 </v-btn>
                            </v-toolbar-title>
                            <v-spacer />
                        </v-toolbar>
                        <!-- ログイン画面 -->
                        <div v-show="tab === 1">
                            <v-card-text>
                                <v-form @submit.prevent="login">
                                    <v-text-field
                                        label="Email"
                                        name="email"
                                        prepend-icon="email"
                                        type="text"
                                        v-model="loginForm.email"
                                    />
                                    <div v-if="loginErrors">
                                        <div
                                            v-for="msg in loginErrors.email"
                                            :key="msg"
                                            style="color: red"
                                        >
                                            {{ msg }}
                                        </div>
                                    </div>
                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="loginForm.password"
                                    />
                                    <div v-if="loginErrors">
                                        <div
                                            v-for="msg in loginErrors.password"
                                            :key="msg"
                                            style="color: red"
                                        >
                                            {{ msg }}
                                        </div>
                                    </div>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer />
                                <v-btn color="primary" @click="login"
                                    >ログイン
                                </v-btn>
                            </v-card-actions>
                        </div>

                        <!-- 登録画面 -->
                        <div v-show="tab === 2">
                            <!-- TODO: formタグが機能しない -->
                            <v-form @submit.prevent="register">
                                <v-card-text>
                                    <v-text-field
                                        label="name"
                                        name="Name"
                                        prepend-icon="mdi-account-circle"
                                        type="text"
                                        v-model="registerForm.name"
                                    />
                                    <div v-if="registerErrors">
                                        <div
                                            v-for="msg in registerErrors.name"
                                            :key="msg"
                                            style="color: red"
                                        >
                                            {{ msg }}
                                        </div>
                                    </div>
                                    <v-text-field
                                        label="Email"
                                        name="email"
                                        prepend-icon="email"
                                        type="text"
                                        v-model="registerForm.email"
                                    />
                                    <div v-if="registerErrors">
                                        <div
                                            v-for="msg in registerErrors.email"
                                            :key="msg"
                                            style="color: red"
                                        >
                                            {{ msg }}
                                        </div>
                                    </div>
                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="registerForm.password"
                                    />
                                    <div v-if="registerErrors">
                                        <div
                                            v-for="msg in registerErrors.password"
                                            :key="msg"
                                            style="color: red"
                                        >
                                            {{ msg }}
                                        </div>
                                    </div>
                                    <v-text-field
                                        id="password_confirmation"
                                        label="Password (confirm)"
                                        name="password_confirmation"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="registerForm.password_confirmation"
                                    />
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer />
                                    <v-btn color="primary" @click="register"
                                        >登録
                                    </v-btn>
                                </v-card-actions>
                            </v-form>
                        </div>
                    </v-card>
                    <!-- </v-col> -->
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
import { mapState } from "vuex";

export default {
    data() {
        return {
            tab: 1,
            loginForm: {
                email: "",
                password: "",
            },
            registerForm: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
        };
    },
    computed: {
        ...mapState({
            /**
             * ストアのapi判定を返す
             * @return {bool}
             */
            apiStatus: (state) => state.auth.apiStatus,
            /**
             * ストアのログインエラーメッセージを返す
             * @return {string}
             */
            loginErrors: (state) => state.auth.loginErrorMessages,
            /**
             * ストアの登録エラーメッセージを返す
             * @returns {string}
             */
            registerErrors: (state) => state.auth.registerErrorMessages,
        }),
        // /**
        //  * ストアのapi判定を返す
        //  * @return {bool}
        //  */
        // apiStatus() {
        //     return this.$store.state.auth.apiStatus;
        // },
        // /**
        //  * ストアのログインエラーメッセージを返す
        //  * @return {string}
        //  */
        // loginErrors() {
        //     return this.$store.state.auth.loginErrorMessages;
        // },
    },
    methods: {
        /**
         * 会員登録api
         */
        async register() {
            // authストアのregisterアクションを呼び出す
            await this.$store.dispatch("auth/register", this.registerForm);
            // trueの場合のみトップページへ遷移
            if (this.apiStatus) {
                this.$router.push("/");
            }
        },
        /**
         * ログインapi
         */
        async login() {
            // authストアのloginアクションを呼び出す
            await this.$store.dispatch("auth/login", this.loginForm);
            if (this.apiStatus) {

                // ログインメッセージ
                this.$store.commit('message/setContent', {
                    content: 'ログインしました。',
                    timeout: 10000
                })

                // trueの場合のみトップページへ遷移
                this.$router.push("/");
            }
        },
        /**
         * エラーメッセージをクリアする
         */
        clearError() {
            this.$store.commit("auth/setLoginErrorMessages", null),
            this.$store.commit("auth/setRegisterErrorMessages", null);
        },
    },
    created() {
        // 表示するタイイングでエラーメッセージをクリア
        this.clearError();
    },
};
</script>
