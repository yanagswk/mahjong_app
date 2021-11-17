<template>
    <v-app>

        <Header />

        <v-main>
            <QuestionCard />
        </v-main>

        <Footer />
    </v-app>
</template>

<script>
import QuestionCard from "./components/QuestionCard.vue";
import Header from "./components/Header.vue";
import Footer from "./components/Footer.vue";

export default {
    name: "App",

    components: {
        QuestionCard,
        Header,
        Footer
    },

    data: () => ({
        //
    }),
};
</script>
