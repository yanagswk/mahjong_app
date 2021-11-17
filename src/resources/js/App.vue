<template>
    <v-app>

        <Header />

        <v-main>
            <HelloWorld />
        </v-main>
    </v-app>
</template>

<script>
import HelloWorld from "./components/HelloWorld.vue";
import Header from "./components/Header.vue";

export default {
    name: "App",

    components: {
        HelloWorld,
        Header
    },

    data: () => ({
        //
    }),
};
</script>
