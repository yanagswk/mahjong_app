<template>
    <v-content>
        <v-container>
            <!-- 各問題 -->
            <QuestionCard
                v-for="question in questions"
                :key="question.id"
                :item="question"
            />
        </v-container>
    </v-content>
</template>

<script>
import QuestionCard from "../components/QuestionCard.vue";

export default {
    name: "QuestionList",
    components: {
        QuestionCard,
    },
    data: () => ({
        questions: []
    }),
    methods: {
        async getMahjongProblem() {
            const response = await axios.get("/api/problem_list");

            if (response.status !== 200) {
                console.log('データが取得できません。');
                return false;
            }

            this.questions = response.data.problem_list;
        }
    },
    watch: {
        // ページが切り替わった時に実行
        $route: {
            async handler() {
                await this.getMahjongProblem();
            },
            immediate: true, // コンポーネントが生成されたタイミングでも実行
        },
    },
};
</script>
