<template>
    <v-card elevation="5" outlined width="1000px" class="mx-auto mt-5 text-center">
        <v-card-title class="card-title-list">
            <div class="question-number">
                問題 : {{ problem.id }}
            </div>
            <div v-if="problem.station" class="card-title-item">
                {{ problem.station }}
            </div>
            <div v-if="problem.direction" class="card-title-item">
                {{ problem.direction }}
            </div>
            <div v-if="problem.round" class="card-title-item">
                {{ problem.round }}巡目
            </div>
            <div v-if="problem.have_point" class="card-title-item">
                持ち点{{ problem.have_point }}
            </div>
            <v-chip
                color="orange"
            >回答数: {{ answer_count }}</v-chip>
            <div v-if="problem.name" class="card-title-item-user">
                ユーザー名: {{ problem.name }}
            </div>
        </v-card-title>

        <v-divider></v-divider>

        <div class="loaders" v-show="loading">
            <vue-loaders name="pacman" color="red" scale="1"></vue-loaders>
        </div>

        <v-card-text v-show="!loading">
            <div class="question-tail-list">
                <div v-for="(tiles, index) in problem.problem_tiles" :key="index" class="question-tail">
                    <v-img
                        :src="tiles"
                        max-height="60"
                        max-width="40"
                    ></v-img>
                </div>
            </div>
        </v-card-text>

        <v-data-table
            :headers="headers"
            :items="user_answer_list"
            :items-per-page="5"
            class="elevation-1"
        >
            <template v-slot:item.ranking="{ item }">
                <v-chip
                    :color="getColor(item.ranking)"
                    dark
                >
                {{ item.ranking }}
                </v-chip>
            </template>
            <template v-slot:item.mahjong_tiles="{ item }">
                <v-img
                        :src="item.mahjong_tiles"
                        max-height="50"
                        max-width="30"
                ></v-img>
            </template>
        </v-data-table>

        <v-card-text>
                <v-btn to="/">
                    問題一覧へ戻る
                </v-btn>
        </v-card-text>

    </v-card>


</template>

<script>
export default {
    data: () => ({
        problem: [],            // 問題
        user_answer_list: [],   // ユーザーの回答
        answer_count: null,     // 総回答数
        headers: [              // ヘッダー
            {text: '順位', value: 'ranking', sortable: false,},
            {text: '牌', value: 'mahjong_tiles', sortable: false,},
            {text: '票数', value: 'answer_count', sortable: false,},
            {text: 'パーセント', value: 'answer_rate', sortable: false,},
        ],
    }),
    computed: {
        loading() {
            return this.$store.getters["loading/loading"];
        },
    },
    methods: {
        /**
         * 問題取得やユーザーの回答を取得するapi
         */
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
            this.problem = response.data.problem;
            console.log(this.problem)
            this.user_answer_list = response.data.user_answer_list;
            this.answer_count = response.data.answer_count;
        },
        /**
         * 順位に対する色を返す
         *
         * @param int ranking 順位
         */
        getColor(ranking) {
            switch (ranking) {
                case 1:
                    return 'red'
                case 2:
                    return 'orange'
                case 3:
                    return 'green'
            }
        }
    },
    // watch: {
    //     // ページが切り替わった時に実行
    //     $route: {
    //         async handler() {
    //             await this.getMahjongProblemAnswer();
    //         },
    //         immediate: true, // コンポーネントが生成されたタイミングでも実行
    //     },
    // },
    mounted() {
        // ローディング開始
        this.$store.dispatch('loading/startLoad')
            .then(()=>this.getMahjongProblemAnswer())
            // ローディング終了
            .then(()=>this.$store.dispatch('loading/endLoad'));
    },
}
</script>

<style scoped>
.card-title-item {
    font-size: 15px;
    padding-right: 5px;
}
.question-number {
    padding-right: 10px;
}
.card-title-item-user {
    font-size: 15px;
    margin-left: auto;
}
.question-tail {
    float: left;
}
.question-tail-list {
    overflow:  auto;
    margin-bottom: 10px;
    display: inline-block;
    text-align: left;
}
</style>
