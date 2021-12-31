- bootstrap.js では Ajax 通信で用いる Axios ライブラリの設定を記述してる。
Ajaxリクエストであることを示す X-Requested-With ヘッダーを付与し、トークンを X-XSRF-TOKEN ヘッダーに含めることで、Laravel はフォームではなくヘッダーを見て CSRF トークンチェックを行う。

- vue-loaders : 3.3.0   ローディング用
  - https://qiita.com/kke1229/items/368a67c7d6df273e137e
  - https://www.kabanoki.net/6414/