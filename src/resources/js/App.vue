<template>
    <v-app>
        <Header />

        <v-main>
            <Message />
            <RouterView />
        </v-main>

        <Footer />
    </v-app>
</template>

<script>
import Message from "./components/message.vue";
import QuestionList from "./pages/QuestionList.vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";
import { INTERNAL_SERVER_ERROR } from "./until";

export default {
    name: "App",
    components: {
        Message,
        QuestionList,
        Header,
        Footer,
    },
    computed: {
        errorCode() {
            return this.$store.state.error.code;
        },
    },
    watch: {
        errorCode: {
            handler(val) {
                if (val === INTERNAL_SERVER_ERROR) {
                    this.$router.push("/500");
                }
            },
            immediate: true,
        },
        $route() {
            this.$store.commit("error/setCode", null);
        },
    },
};
</script>
