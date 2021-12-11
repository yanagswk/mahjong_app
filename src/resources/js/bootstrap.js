import { getCookieValue } from "./until";

window._ = require("lodash");

window.axios = require("axios");

// Ajaxリクエストであることを示すヘッダーを付与する
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    require("bootstrap");
} catch (e) {}

window.axios.interceptors.request.use((config) => {
    // クッキーからトークンを取り出してヘッダーに添付する
    config.headers["X-XSRF-TOKEN"] = getCookieValue("XSRF-TOKEN");
    return config;
});
