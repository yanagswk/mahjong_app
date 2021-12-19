<template>
    <v-card elevation="5" outlined width="1000px" class="mx-auto mt-5 text-center">
        <v-card-text>
            <div class="question-tail-list">
                <!-- TODO: リファクタリングしたい -->
                <div class="mb-3 tiles_list">
                    <div v-for="(tiles, index) in manzu_list" :key="index" class="question-tail">
                        <!-- TODO: mahjong_tilesをmahjong_tiles_imgに変える(カラム名を変えることになりそう) -->
                        <v-img
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                            class="image-mouse"
                            @click="click_select(tiles)"
                        ></v-img>
                    </div>
                </div>
                <div class="mb-3 tiles_list">
                    <div v-for="(tiles, index) in pinzu_list" :key="index" class="question-tail">
                        <v-img
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                            class="image-mouse"
                            @click="click_select(tiles)"
                        ></v-img>
                    </div>
                </div>
                <div class="mb-3 tiles_list">
                    <div v-for="(tiles, index) in souzu_list" :key="index" class="question-tail">
                        <v-img
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                            class="image-mouse"
                            @click="click_select(tiles)"
                        ></v-img>
                    </div>
                </div>
                <div class="mb-10 tiles_list">
                    <div v-for="(tiles, index) in jihai_list" :key="index" class="question-tail">
                        <v-img
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                            class="image-mouse"
                            @click="click_select(tiles)"
                        ></v-img>
                    </div>
                </div>

                <div v-for="(tiles, index) in select_tiles_list" :key="index" class="question-tail mr-1">
                    <!-- TODO: 用意できる牌の数より多くなったら選択できないようにする(例えば中が5つはありえない) -->
                    <div v-if="!tiles">
                        <v-sheet
                            color="grey darken-2"
                            elevation="1"
                            height="60"
                            width="40"
                            style="overflow: auto;"
                        ></v-sheet>
                    </div>
                    <div v-else>
                        <v-img
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                        ></v-img>
                    </div>
                </div>

            </div>
        </v-card-text>


<!-- <v-card>
    <v-img
        src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
        height="200px"
        class="woo" style="overflow: visible"
    >
    <v-avatar style="postion:absolute; left: 44%; top: 80% " rounded width="80px" class="pa-1" height="80px">
        <img width="80" height="80" src="https://cdn.vuetifyjs.com/images/lists/1.jpg">
    </v-avatar>
    </v-img>
</v-card> -->


        <v-btn
            elevation="5"
            @click="sort_tiles()"
            >理牌する
        </v-btn>

        <v-select
            :items="station_list"
            label="局"
            dense
            outlined
            class="select-box"
        ></v-select>

        <v-select
            :items="direction_list"
            label="自風"
            dense
            outlined
            class="select-box"
        ></v-select>

        <v-select
            :items="round_list"
            label="巡目"
            dense
            outlined
            class="select-box"
        ></v-select>

        <v-select
            :items="tiles_name_list"
            label="ドラ"
            dense
            outlined
            class="select-box"
        ></v-select>

    </v-card>
</template>

<script>
import { OK, MANZU_NUMBER, PINZU_NUMBER, SOUZU_NUMBER, JIHAI_NUMBER } from "../until";

export default {
    data() {
        return {
            station_list: [],       // 局リスト
            direction_list: [],     // 自風リスト
            tiles_list: [],         // 牌リストs
            tiles_group_list: [],   // 牌のグループリスト
            tiles_name_list: [],
            // tiles_image: [],
            round: 0,
            round_list: [],
            isVisible: false,
            my_tiles_length: 13,     // 手牌数
            click_count: 0,             // クリックされた数
            select_tiles_list: [],       // クリックされた牌を格納
            manzu_list: [],             // 萬子リスト
            pinzu_list: [],             // 筒子リスト
            souzu_list: [],             // 索子リスト
            jihai_list: [],             // 索子リスト
        }
    },
    methods: {
        /**
         * 回答を選択
         * @param {object} tiles 選択した牌の情報
         */
        click_select(tiles) {
            // 手牌数が規定値よりも多くなったら終了
            if (this.click_count >= this.my_tiles_length) {
                return false;
            }
            if (!this.isVisible) {
                this.isVisible = true;
            }
            // 配列に画像パスを代入し、変更を検知させる
            this.$set(this.select_tiles_list, this.click_count, tiles);
            this.click_count ++;
        },
        /**
         * 巡目の配列を作る
         */
        create_round_list() {
            for (let i=1; i<=this.round; i++) {
                let round_unit = `${i}巡目`;
                this.round_list.push(round_unit);
            }
        },
        /**
         * 牌のみのリストリストを作る
         */
        create_tiles_name_list() {
            this.tiles_name_list = this.tiles_list.map(tiles => tiles.tiles_name);
        },
        /**
         * 選択された牌を格納するリスト
         * 初期値としてfalse追加
         */
        create_select_tiles_list() {
            for (let i=0; i<this.my_tiles_length; i++) {
                this.select_tiles_list.push(false);
            }
        },
        /**
         * 理牌する(牌をidの昇順に並べ替える)
         */
        sort_tiles() {
            this.select_tiles_list.sort((a, b) => a.id - b.id);
        },
        /**
         * 牌のグループごとの配列作成
         * TODO: グループごとの判定 リファクタリング
         */
        create_tiles_each_group() {
            this.tiles_list.forEach(tiles => {
                // 萬子
                if (tiles.tiles_group_id === MANZU_NUMBER) {
                    this.manzu_list.push({
                        'id': tiles.id,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 筒子
                if (tiles.tiles_group_id === PINZU_NUMBER) {
                    this.pinzu_list.push({
                        'id': tiles.id,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 索子
                if (tiles.tiles_group_id === SOUZU_NUMBER) {
                    this.souzu_list.push({
                        'id': tiles.id,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 字牌
                if (tiles.tiles_group_id === JIHAI_NUMBER) {
                    this.jihai_list.push({
                        'id': tiles.id,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
            });
        },
        /**
         * 問題投稿api
         */
        async get_question_situation() {
            const response = await axios.get("/api/post_question");

            if (response.status !== OK) {
                console.log('データが取得できません。');
                return false;
            }
            this.station_list = response.data.station_list;
            this.direction_list = response.data.direction_list;
            this.tiles_list = response.data.tiles_name_list;
            this.round = response.data.round;
            this.tiles_group_list = response.data.tiles_group_list;
        }
    },
    watch: {
        // ページが切り替わった時に実行
        $route: {
            async handler() {
                await this.get_question_situation();
                this.create_round_list();
                this.create_tiles_name_list();
                this.create_select_tiles_list();
                this.create_tiles_each_group();
            },
            immediate: true, // コンポーネントが生成されたタイミングでも実行
        },
    },
}
</script>

<style scoped>
.question-tail {
    float: left;
    /* overflow: auto; */
}
.question-tail-list {
    overflow:  auto;
    margin-bottom: 10px;
    display: inline-block;
    text-align: left;
}
.tiles_list {
    overflow: auto;
}
.image-mouse {
    cursor: pointer;
}
.select-box {
    width: 200px;
}
</style>
