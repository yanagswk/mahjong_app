export const OK = 200                       // 成功
export const CREATED = 201                  // 新規登録
export const INTERNAL_SERVER_ERROR = 500    // サーバーエラー
export const UNPROCESSABLE_ENTITY = 422     // バリデーションエラー

export const MANZU_NUMBER = 1               // 萬子
export const PINZU_NUMBER = 2               // 筒子
export const SOUZU_NUMBER = 3               // 索子
export const JIHAI_NUMBER = 4               // 字牌

/**
 * クッキーの値を生成する
 *
 * document.cookieにより以下の形式でcookie取得
 * name=12345;token=67890;key=abcde
 *
 * @param {String} searchKey 検索するキー
 * @returns {String} キーに対応する値
 */
export function getCookieValue(searchKey) {
    let val = '';
    if (typeof searchKey === 'undefined') {
        return '';
    }
    document.cookie.split(';').forEach(cookie => {
        const [key, value] = cookie.split('=');
        if (key === searchKey) {
            return val = value;
        }
    })
    return val;
}

