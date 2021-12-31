<template>
<v-container>

    <v-card elevation="5" outlined width="1000px" class="mx-auto mt-5 text-center">
        <v-card-text>
            <div class="question-tail-list">
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
                <!-- <div v-for="index of my_tiles_length" :key="index" class="question-tail mr-1"> -->
                    <!-- TODO: 牌の数　制限設ける -->
                    <v-sheet
                        color="grey darken-1"
                        elevation="1"
                        height="55"
                        width="40"
                    >
                        <v-img
                            v-if="tiles.mahjong_tiles"
                            :src="tiles.mahjong_tiles"
                            max-height="60"
                            max-width="40"
                        ></v-img>
                    </v-sheet>
                </div>
            </div>
        </v-card-text>

        <v-btn
            elevation="5"
            @click="sort_tiles()"
            >理牌する
        </v-btn>

        <v-btn
            elevation="5"
            @click="reset_tiles()"
            >リセット
        </v-btn>

        <v-divider class="mx-3 my-3"></v-divider>

        <!-- <v-row class="text-center"> -->
            <v-form @submit.prevent="post_question">
                <div style="display: flex;">

                <!-- <v-col cols="2"> -->


                    <v-select
                        v-model="select_station"
                        label="局"
                        :items="station_list"
                        item-text="station"
                        item-value="id"
                        class="select-box"
                        dense
                        outlined
                    ></v-select>
                <!-- </v-col> -->

                <!-- <v-col cols="2"> -->
                    <v-select
                        v-model="select_direction"
                        label="自風"
                        :items="direction_list"
                        item-text="direction"
                        item-value="id"
                        class="select-box"
                        dense
                        outlined
                    ></v-select>
                <!-- </v-col> -->

                <!-- <v-col cols="2"> -->
                    <v-select
                        v-model="select_round"
                        :items="round_list"
                        item-text="round"
                        item-value="id"
                        label="巡目"
                        class="select-box"
                        dense
                        outlined
                    ></v-select>
                <!-- </v-col> -->

                    <v-select
                        v-model="select_dora_tiles"
                        :items="select_list"
                        item-text="tiles_name"
                        item-value="id"
                        label="ドラ"
                        class="select-box"
                        dense
                        outlined
                    ></v-select>

                    <v-text-field
                        ref="count"
                        label="持ち点"
                        v-model.number="have_point"
                        type="number"
                        max="100000"
                        min="0"
                        step="1000"
                        class="select-box"
                    ></v-text-field>

                </div>

                <v-chip color="red">
                    ユーザー名 : {{ username }}
                </v-chip>

                <v-select
                    v-model="select_answer_tiles"
                    :items="select_list"
                    item-text="tiles_name"
                    item-value="id"
                    label="回答の牌"
                    dense
                    outlined
                    required
                    style="width: 200px;"
                ></v-select>

                <v-textarea
                    width="500px"
                    solo
                    label="解説"
                    elevation="5"
                    v-model="commentary"
                ></v-textarea>

                <v-card-actions>
                    <v-btn
                        type="submit"
                        block
                        elevation="2"
                    >問題を投稿する
                    </v-btn>
                </v-card-actions>
            <!-- </div> -->
            </v-form>
        <!-- </v-row> -->

    </v-card>
    </v-container>
</template>

<script>
import { OK, MANZU_NUMBER, PINZU_NUMBER, SOUZU_NUMBER, JIHAI_NUMBER } from "../until";
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            station_list: [],       // 局リスト
            direction_list: [],     // 自風リスト
            tiles_list: [],         // 牌リスト
            tiles_group_list: [],   // 牌のグループリスト
            tiles_name_list: [],
            round: 0,
            round_list: [],
            isVisible: false,
            my_tiles_length: 13,        // 手牌数
            click_count: 0,             // クリックされた数
            select_tiles_list: [],       // クリックされた牌を格納
            select_tiles_name_list: [],  // クリックされた牌の名前を格納
            select_tiles_id_list: [],   // クリックされた牌のidを格納
            manzu_list: [],             // 萬子リスト
            pinzu_list: [],             // 筒子リスト
            souzu_list: [],             // 索子リスト
            jihai_list: [],             // 索子リスト
            commentary: '',             // 解説
            have_point: null,           // 持ち点
            select_station: '',         // 選択された局
            select_direction: '',      // 選択された自風
            select_answer_tiles: '',    // 選択された回答の牌
            select_dora_tiles: '',      // 選択されたドラの牌
            select_round: '',            // 選択された巡目
            select_list: []                // 選択された牌(falseなし)
        }
    },
    computed: {
        ...mapGetters({
            /**
             * ログインユーザーID
             */
            userId: 'auth/userId',
            /**
             * ログインユーザー名
             * @return {string}
             */
            username: 'auth/username'
        })
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

            // クリックした牌の名前のみ格納
            // TODO: いらない？？
            this.select_tiles_name_list.push(tiles.tiles_name);

            this.select_tiles_id_list.push(tiles.id);

            this.select_list.push(tiles);
        },
        /**
         * 巡目の配列を作る
         */
        create_round_list() {
            for (let i=1; i<=this.round; i++) {
                let round = `${i}巡目`;
                this.round_list.push({
                    'id': i,
                    'round': round
                });
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
         * TODO: falseのリスト作らなくてもいける
         */
        create_select_tiles_list() {
            for (let i=0; i<this.my_tiles_length; i++) {
                this.select_tiles_list.push('');
            }
        },
        /**
         * 理牌する(牌をidの昇順に並べ替える)
         */
        sort_tiles() {
            this.select_tiles_list.sort((a, b) => a.id - b.id);
            this.select_list.sort((a, b) => a.id - b.id);
        },
        /**
         * 選択された牌リストをリセットする
         * TODO: 「指定しない」を追加 のところどうにかする
         */
        reset_tiles() {
            this.select_tiles_list.splice(0);
            this.select_list.splice(0);
            this.create_select_tiles_list();
            this.click_count = 0;

            // 「指定しない」を追加
            const unselectDoraObj = {
                id: 0,
                tiles_name: '指定しない'
            }
            this.select_list.unshift(unselectDoraObj);
            this.select_dora_tiles = unselectDoraObj.id;
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
                        'tiles_name': tiles.tiles_name,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 筒子
                if (tiles.tiles_group_id === PINZU_NUMBER) {
                    this.pinzu_list.push({
                        'id': tiles.id,
                        'tiles_name': tiles.tiles_name,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 索子
                if (tiles.tiles_group_id === SOUZU_NUMBER) {
                    this.souzu_list.push({
                        'id': tiles.id,
                        'tiles_name': tiles.tiles_name,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
                // 字牌
                if (tiles.tiles_group_id === JIHAI_NUMBER) {
                    this.jihai_list.push({
                        'id': tiles.id,
                        'tiles_name': tiles.tiles_name,
                        'mahjong_tiles': tiles.mahjong_tiles
                    });
                }
            });
        },
        /**
         * 「指定しない」を配列に追加して、初期値設定
         * TODO: リファクタリング
         */
        addUnselect() {
            // 自風
            const unselectDirectionObj = {
                id: 0,
                direction: '指定しない'
            }
            this.direction_list.unshift(unselectDirectionObj);
            this.select_direction = unselectDirectionObj.id;

            // 局
            const unselectStationObj = {
                id: 0,
                station: '指定しない'
            }
            this.station_list.unshift(unselectStationObj);
            this.select_station = unselectStationObj.id;

            // ドラ
            const unselectDoraObj = {
                id: 0,
                tiles_name: '指定しない'
            }
            this.select_list.unshift(unselectDoraObj);
            this.select_dora_tiles = unselectDoraObj.id;

            // 巡目
            const unselectRoundObj = {
                id: 0,
                round: '指定しない'
            }
            this.round_list.unshift(unselectRoundObj);
            this.select_round = unselectRoundObj.id;
        },
        /**
         *  バリデーションチェック
         */
        validation_check() {
            // 選択牌チェック
            if (!this.chkSelectTilesList()) {
                console.log('選択エラー')
                return false;
            }
            // 局チェック

            // 自風チェック

            // 巡目チェック

            // ドラチェック

            // 持ち点チェック
            if (!this.chkHavePoint()) {
                console.log('持ち点エラー')
                return false;
            }

            // 回答の牌チェック
            if (!this.chkSelectAnswerTiles()) {
                console.log('回答エラー')
                return false
            }

            // 解説チェック
            if (!this.chkCommentary()) {
                console.log('解説エラー');
                return false
            }

            return true;

        },
        /**
         * 選択された牌チェック
         * 牌の数が14以下だった場合はfalse
         * 「指定しない」の項目を考慮して13ではなく14
         * @return {bool} true: ok / false: ng
         */
        chkSelectTilesList() {
            if (this.select_list.length !== this.my_tiles_length+1) {
                return false
            }
            return true;
        },
        /**
         * 回答チェック
         * @return {bool} true: ok / false: ng
         */
        chkSelectAnswerTiles() {
            // 空の場合false
            if (!this.select_answer_tiles) {
                return false;
            }
            // TODO: 問題リスト内に含まれてるか
            return true;
        },
        /**
         * 持ち点チェック
         */
        chkHavePoint() {
            // 空の場合は正常
            if (!this.have_point) {
                return true;
            }
            // 文字が含んでたらNaNが返る
            if (!Number(this.have_point)) {
                return false;
            }
            // 文字列の場合の変換や小数点切り捨て
            this.have_point = parseInt(this.have_point);
            return true;
        },
        /**
         * 解説エラー
         */
        chkCommentary() {
            // 空白や改行のみの場合
            // https://qiita.com/TK-C/items/ebb818a1c2075332d5be
            if (!this.commentary.match(/\S/g)) {
                this.commentary = '';
            }
            // TODO: htmlspecialchars()的なのはいらない？？
            return true;
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
        },
        /**
         * 問題を送信
         */
        async post_question() {
            // 理牌する
            const sort_tiles_id_list = this.select_tiles_id_list.sort((a, b) => a - b);

            // バリデーションチェック
            if (!this.validation_check()) {
                return false;
            }

            // return false

            const post_data = {
                tiles_id_list: sort_tiles_id_list,
                user_id: this.userId,
                station: this.select_station,
                direction: this.select_direction,
                answer_tiles: this.select_answer_tiles,
                dora_tiles: this.select_dora_tiles,
                round: this.select_round,
                have_point: this.have_point,
                commentary: this.commentary,
            }
            const response = await axios.post("/api/post_question", post_data);

            if (response.status !== OK) {
                return false;
            }

            // 問題一覧ページへ遷移
            this.$router.push("/");

        },
        /**
         * データセット
         */
        setData() {
            this.create_round_list();
            this.create_tiles_name_list();
            this.create_select_tiles_list();
            this.create_tiles_each_group();
            this.addUnselect()
        }
    },
    /**
     * ナビゲーション前に取得
     */
    async beforeRouteEnter(to, from, next) {
        // 問題投稿api
        const response = await axios.get("/api/post_question");
        if (response.status !== OK) {
            return false;
        }
        next(async (vm) => {
            vm.station_list = response.data.station_list;
            vm.direction_list = response.data.direction_list;
            vm.tiles_list = response.data.tiles_name_list;
            vm.round = response.data.round;
            vm.tiles_group_list = response.data.tiles_group_list;
            vm.setData();
            next();
        });

    },
    // watch: {
    //     // ページが切り替わった時に実行
    //     $route: {
    //         async handler() {
    //             await this.get_question_situation();
    //             this.create_round_list();
    //             this.create_tiles_name_list();
    //             this.create_select_tiles_list();
    //             this.create_tiles_each_group();
    //             this.addUnselect()
    //         },
    //         immediate: true, // コンポーネントが生成されたタイミングでも実行
    //     },
    // },
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
    width: 70px;
}
</style>
