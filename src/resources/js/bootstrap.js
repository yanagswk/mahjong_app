// import { getCookieValue } from "./util";

// window._ = require("lodash");

// window.axios = require("axios");

// // Ajaxリクエストであることを示すヘッダーを付与する
// window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// try {
//     window.Popper = require("popper.js").default;
//     window.$ = window.jQuery = require("jquery");

//     require("bootstrap");
// } catch (e) {}

// window.axios.interceptors.request.use((config) => {
//     // クッキーからトークンを取り出してヘッダーに添付する
//     config.headers["X-XSRF-TOKEN"] = getCookieValue("XSRF-TOKEN");
//     return config;
// });

import { getCookieValue } from './until'

window.axios = require('axios')

// Ajaxリクエストであることを示すヘッダーを付与する
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

window.axios.interceptors.request.use(config => {
  // クッキーからトークンを取り出してヘッダーに添付する
    config.headers['X-XSRF-TOKEN'] = getCookieValue('XSRF-TOKEN')

    return config
})

// レスポンスを受けた後の処理を上書き
window.axios.interceptors.response.use(
    response => response,
    error => error.response || error
)
