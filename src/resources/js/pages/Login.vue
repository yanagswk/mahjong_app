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
                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="loginForm.password"
                                    />
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer />
                                <v-btn
                                    color="primary"
                                    @click="login"
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
                                    <v-text-field
                                        label="Email"
                                        name="email"
                                        prepend-icon="email"
                                        type="text"
                                        v-model="registerForm.email"
                                    />
                                    <v-text-field
                                        id="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="registerForm.password"
                                    />
                                    <v-text-field
                                        id="password_confirmation"
                                        label="Password (confirm)"
                                        name="password_confirmation"
                                        prepend-icon="lock"
                                        type="password"
                                        v-model="
                                            registerForm.password_confirmation
                                        "
                                    />
                                </v-card-text>
                                <v-card-actions>
                                    <v-spacer />
                                    <v-btn
                                        color="primary"
                                        @click="register"
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
export default {
    data() {
        return {
            tab: 1,
            loginForm: {
                name: "",
                email: "",
            },
            registerForm: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
            },
        };
    },
    methods: {
        /**
         * 会員登録api
         */
        async register() {
            // authストアのregisterアクション呼び出し
            await this.$store.dispatch("auth/register", this.registerForm);
            this.$router.push("/");
        },
        /**
         * ログインapi
         */
        async login() {
            // authストアのloginアクションを呼び出す
            await this.$store.dispatch("auth/login", this.loginForm);
            this.$router.push("/");
        },
    },
};
</script>
