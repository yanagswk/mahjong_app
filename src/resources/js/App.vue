<template>
    <v-app>

        <Header />

        <v-main>
            <RouterView />
        </v-main>

        <Footer />
    </v-app>
</template>

<script>
import QuestionList from "./pages/QuestionList.vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

export default {
    name: "App",

    components: {
        QuestionList,
        Header,
        Footer
    },

    data: () => ({
        //
    }),
};
</script>
