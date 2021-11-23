<template>
    <v-row class="text-center">
        <v-card width="900px" class="mx-auto mt-5">
            <!-- タイトルを表示します。 -->
            <v-card-title>タイトルuu</v-card-title>
            <!-- サブタイトルを表示します。 -->
            <v-card-subtitle>サブタイトル</v-card-subtitle>
            <!-- 本文を表示します。 -->
            <v-card-text>本文</v-card-text>
        </v-card>
    </v-row>
</template>

<script>
export default {
    props: {
        item: {
            // type: Object,
            required: true
        }
    },
    created() {
        console.log(this.item);
    }
}
</script>
