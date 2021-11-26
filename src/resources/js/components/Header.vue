<template>
    <!-- divタグがないとヘッダーの高さが固定されない -->
    <div>
    <!-- ヘッダー -->
        <v-app-bar color="pink accent-4" dark>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <router-link to="/">
                <v-btn>
                    <v-toolbar-title>麻雀 何キル？？？</v-toolbar-title>
                </v-btn>
            </router-link>

            <div class="flex-grow-1"></div>

            <router-link to="/post_question">
                <v-btn color="red" elevation="10">問題を投稿する</v-btn>
            </router-link>

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
