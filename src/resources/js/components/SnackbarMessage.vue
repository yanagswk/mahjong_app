<template>
    <v-card
        style="display: flex; padding: 6px 12px"
        :color="message.color"
    >
        <div style="display: flex; align-items: center">{{ message.content }}</div>
        <v-spacer></v-spacer>
        <v-btn icon depressed @click="remove()">
            <v-icon color="rgba(51, 51, 51, 0.3)">cancel</v-icon>
        </v-btn>
    </v-card>
</template>

<script>
export default {
    props: {
        message: Object,
    },

    data() {
        return {
            activeTimeout: -1,
        };
    },

    mounted() {
        // メッセージコンポーネントがマウントされた時点からカウント開始
        this.setTime();
    },

    methods: {
        setTime() {
            clearTimeout(this.activeTimeout);
            const timeout = this.message.timeout;
            // タイムアウト時間が設定されている場合は
            if (timeout) {
                // 指定時間後にremoveを呼び出す
                this.activeTimeout = setTimeout(() => {
                    this.remove();
                }, timeout);
            }
        },

        // 親コンポーネントにremoveを発火
        remove() {
            this.$emit("remove");
        },
    },
};
</script>
