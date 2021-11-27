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
            <v-img
                :src="item.problem_image_url"
                max-height="300"
                max-width="500"
            ></v-img>

            <!-- https://yacchi-engineer.com/?p=1465 -->
            <v-card width="300px" style="margin-top:10px">
                <v-container grid-list-xs>
                    <v-row>
                        <!-- FIXME: for文回したい -->
                        <!-- <v-col md="3" v-for="(answer, index) in answer_list" :key="index"> -->
                        <v-col md="3">
                            <!-- <v-btn> -->
                                <!-- FIXME: ボタンこうしたい　https://vuetifyjs.com/ja/components/cards/#section-4f7f304465b9  -->
                            <v-img
                                :src="item.answer_select_one"
                                max-height="70"
                                max-width="50"
                                class="image-mouse"
                                @click="click_select(item.answer_select_one)"
                            ></v-img>
                            <!-- </v-btn> -->
                        </v-col>
                        <v-col md="3">
                            <v-img
                                :src="item.answer_select_two"
                                max-height="70"
                                max-width="50"
                                class="image-mouse"
                                @click="click_select(item.answer_select_two)"
                            ></v-img>
                        </v-col>
                        <v-col md="3">
                            <v-img
                                :src="item.answer_select_three"
                                max-height="70"
                                max-width="50"
                                class="image-mouse"
                                @click="click_select(item.answer_select_three)"
                            ></v-img>
                        </v-col>
                        <v-col md="3">
                            <v-img
                                :src="item.answer_select_fore"
                                max-height="70"
                                max-width="50"
                                class="image-mouse"
                                @click="click_select(item.answer_select_fore)"
                            ></v-img>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card>

            <div v-show="isVisible">
                <v-card-text>選択した牌 :
                    <v-img
                        :src="select_img"
                        max-height="30"
                        max-width="20"
                        class="select-hei"
                    ></v-img>
                </v-card-text>
                <!-- FIXME: textareaの幅調整したい -->
                <v-textarea
                    width="500px"
                    solo
                    label="コメント"
                    elevation="5"
                ></v-textarea>
                <v-card-actions>
                    <v-btn
                        block
                        elevation="2"
                        @click="reserve"
                    >回答する</v-btn>
                </v-card-actions>
            </div>

        </v-card>
    </v-row>
</template>

<script>
export default {
    data() {
        return {
            // image_src: require("/Users/yanagisawa/src/myapp/mahjong_app/src/public/image/question01.png"),
            // image_src: require(this.item.problem_image_url),
            image_src: require("../../../public/image/question01.png"),
            // answer_list: [
            //     {answer_img : require("../../../public/image/hai/two_man.png")},
            //     {answer_img : require("../../../public/image/hai/three_man.png")},
            //     {answer_img : require("../../../public/image/hai/four_sou.png")},
            //     {answer_img : require("../../../public/image/hai/five_sou.png")},
            // ],
            isVisible: false,
            select_img: '',
        }
    },
    props: {
        item: {
            // type: Object,
            required: true,
        },
    },
    methods: {
        click_select(img) {
            console.log(img);
            if (!this.isVisible) {
                this.isVisible = true;
            }
            this.select_img = img;
        }
    },
    created() {
        console.log(this.item.problem_image_url);
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

</style>
