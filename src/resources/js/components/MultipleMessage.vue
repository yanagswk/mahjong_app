<template>
    <!--
    タイムアウトの管理は、大枠ではせずメッセージ毎に行う
    全てのメッセージが消えたら大枠を消す
    大枠を消す処理はStoreに実装する
    -->

    <v-snackbar :top="true" v-model="isShow" :timeout="0" auto-height>
        <!-- メッセージを縦並びにするためdivタグでラップする -->
        <div style="margin: -14px auto; width: 100%">
            <div style="margin: 0 -24px">
                <template v-for="(message, index) in getMessages">
                    <SnackbarMessage
                        :key="message.id"
                        @remove="removeMessage({ id: message.id })"
                        :message="message"
                    />
                    <div
                        style="margin: 1px 0"
                        v-if="index != lastIndex"
                        :key="`${message.id}-divider`"
                    />
                </template>
            </div>
        </div>
    </v-snackbar>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
// メッセージ表示用コンポーネント
import SnackbarMessage from "./SnackbarMessage.vue";

export default {
    components: {
        SnackbarMessage,
    },

    computed: {
        ...mapGetters({
            /**
             * メッセージが格納されてるか
             *  true:格納されてる / false:格納されてない
             */
            isShow: "message/isShow",
            getMessages: "message/getMessages"
        }),

        lastIndex() {
            // return this.messages.length - 1;
            return this.getMessages.length - 1;
        },
    },

    methods: {
        ...mapActions({
            // removeMessage: actionType.snackbar.REMOVE_MESSAGE,
            removeMessage: "message/REMOVE_MESSAGE",
        }),
    },
};
</script>
