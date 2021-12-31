<template>
    <v-content>
        <v-container>
            <div class="loaders" v-show="loading">
                <vue-loaders name="pacman" color="red" scale="1"></vue-loaders>
            </div>
            <div v-show="!loading">
                <!-- 各問題 -->
                <QuestionCard
                    v-for="question in questions"
                    :key="question.id"
                    :item="question"
                />
            </div>
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
    computed: {
        loading(){
            return this.$store.getters["loading/loading"];
        },
    },
    methods: {
        /**
         * 問題一覧取得
         */
        async getMahjongProblem() {
            const response = await axios.get("/api/problem_list");

            if (response.status !== 200) {
                console.log('データが取得できません。');
                return false;
            }

            this.questions = response.data.problem_list;
        },
    },
    // watch: {
    //     // ページが切り替わった時に実行
    //     $route: {
    //         async handler() {
    //             await this.getMahjongProblem();
    //         },
    //         immediate: true, // コンポーネントが生成されたタイミングでも実行
    //     },
    // },
    mounted() {
        // ローディング開始
        this.$store.dispatch('loading/startLoad')
            .then(()=>this.getMahjongProblem())
            // ローディング終了
            .then(()=>this.$store.dispatch('loading/endLoad'));
    },

};
</script>

<style scoped>
.loaders {
    text-align: center;
}
</style>
