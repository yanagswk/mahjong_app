<template>
    <!-- <v-row class="text-center"> -->
    <v-row>
        <v-card elevation="5" outlined width="1000px" class="mx-auto mt-5">
            <v-card-title class="card-title-list">
                <div class="question-number">
                    問題 : {{ item.id }}
                </div>
                <div v-if="item.station" class="card-title-item">
                    {{ item.station }}
                </div>
                <div v-if="item.direction" class="card-title-item">
                    {{ item.direction }}
                </div>
                <div v-if="item.round" class="card-title-item">
                    {{ item.round }}巡目
                </div>
                <div v-if="item.have_point" class="card-title-item">
                    持ち点{{ item.have_point }}
                </div>
                <!-- TODO: ユーザーのアイコン入れる -->
                <div v-if="item.user_id" class="card-title-item-user">
                    ユーザー名{{ item.user_id }}
                </div>
            </v-card-title>

            <v-divider class="mx-3"></v-divider>
            <v-card-text>{{ item.problem_description }}</v-card-text>

            <div class="question-tail-list">
                <div v-for="(tiles, index) in item.problem_tiles" :key="index" class="question-tail">
                    <!-- <v-btn> -->
                    <!-- FIXME: ボタンこうしたい　https://vuetifyjs.com/ja/components/cards/#section-4f7f304465b9  -->
                    <v-img
                        :src="tiles"
                        max-height="70"
                        max-width="50"
                        class="image-mouse"
                        @click="click_select(tiles)"
                    ></v-img>
                    <!-- </v-btn> -->
                </div>
            </div>

            <!-- https://yacchi-engineer.com/?p=1465 -->
            <!-- <v-card width="300px">
                <v-container grid-list-xs>
                    <v-row>
                        <v-col md="3" v-for="(key, index) in item.select" :key="index">
                            <v-img
                                :src="key"
                                max-height="70"
                                max-width="50"
                                class="image-mouse"
                                @click="click_select(key)"
                            ></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card> -->

            <v-card-text>
                <v-btn
                    :to="`question_answer/${this.item.id}`"
                    small
                >
                    問題の回答・集計結果を見る
                </v-btn>
            </v-card-text>

            <div v-show="isVisible">
                <v-card-text>選択した牌 :
                    <v-img
                        :src="selectImg"
                        max-height="30"
                        max-width="20"
                        class="select-hei"
                    ></v-img>
                </v-card-text>

                <v-form @submit.prevent="answer_submit">
                    <!-- FIXME: textareaの幅調整したい -->
                    <v-textarea
                        width="500px"
                        solo
                        label="コメント"
                        elevation="5"
                        v-model="userComment"
                    ></v-textarea>

                    <v-card-text>{{ userComment }}</v-card-text>

                    <v-card-actions>
                        <v-btn
                            type="submit"
                            block
                            elevation="2"
                        >回答する
                        </v-btn>
                    </v-card-actions>
                </v-form>

            </div>

        </v-card>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            isVisible: false,
            selectImg: '',
            userComment: '',
        }
    },
    props: {
        item: {
            // type: Object,
            required: true,
        },
    },
    methods: {
        /**
         * 回答を選択
         * @param img string 選択肢した画像
         */
        click_select(img) {
            if (!this.isVisible) {
                this.isVisible = true;
            }
            this.selectImg = img;
        },
        /**
         * 回答を送信
         */
        async answer_submit() {
            // 問題のid、選択肢した牌、コメント、ユーザー情報
            const response = await axios.post("/api/post_answer", {
                question_number: this.item.id,
                select_img: this.selectImg,
                comment: this.userComment
            });

            if (response.status !== 200) {
                console.log('更新に失敗しました。');
                return false;
            }

            // 問題の回答ページへ遷移
            this.$router.push(`question_answer/${this.item.id}`);
            // this.$router.push({
            //     // name: `question_answer/${this.item.id}`,
            //     name: "/question_answer/:id",
            //     params: {item: this.item}
            // });
        }
    },
};
// <!-- src="https://cdn.vuetifyjs.com/images/cards/cooking.png" -->
</script>

<style scoped>
.image-mouse {
    cursor: pointer;
}
.select-hei {
    display: inline-block;
}
.card-title-item {
    /* display: inline-block; */
    /* float:left; */
    font-size: 15px;
    padding-right: 5px;
}
.card-title-item-user {
    font-size: 15px;
    margin-left: auto;
}
.question-number {
    padding-right: 10px;
}
.question-tail {
    float: left;
}
.question-tail-list {
    overflow:  auto;
    margin-bottom: 10px;
}

</style>
