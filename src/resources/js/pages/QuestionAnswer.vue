<template>

    <v-card elevation="5" outlined width="1000px" class="mx-auto mt-5">
        <v-card-text>
            <!-- {{ this.questions }} -->
            {{ this.$route.params.id }}
        </v-card-text>

    </v-card>


</template>

<script>
export default {
    data: () => ({
        questions: []
    }),
    methods: {
        async getMahjongProblemAnswer() {
            const response = await axios.get("/api/answer_result", {
                params: {
                    question_id: this.$route.params.id
                }
            })
            if (response.status !== 200) {
                console.log('データが取得できません。');
                return false;
            }

            this.questions = response.data.problem_list;
            console.log(this.questions);
        }
    },
    watch: {
        // ページが切り替わった時に実行
        $route: {
            async handler() {
                await this.getMahjongProblemAnswer();
            },
            immediate: true, // コンポーネントが生成されたタイミングでも実行
        },
    },
}
</script>
