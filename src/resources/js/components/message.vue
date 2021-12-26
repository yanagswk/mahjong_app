<template>
    <v-snackbar v-model="flag" :timeout="timeout">
        {{ content }}
        <template v-slot:action="{ attrs }">
            <v-btn color="pink" text v-bind="attrs" @click="deleteContent()">
                Close
            </v-btn>
        </template>
    </v-snackbar>

</template>

<script>
import { mapState, mapMutations } from "vuex";

export default {
    computed: {
        ...mapState({
            /**
             * メッセージ本文
             */
            content: (state) => state.message.content,
            /**
             * メッセージフラグ
             */
            flag: (state) => state.message.flag,
            /**
             * メッセージ表示時間
             */
            timeout: (state) => state.message.timeout
        }),
    },
    methods: {
        ...mapMutations({
            /**
             * メッセージダイアログ削除
             */
            deleteContent: "message/deleteContent"
        })
    }
};
</script>
