- bootstrap.js では Ajax 通信で用いる Axios ライブラリの設定を記述しています。
Ajaxリクエストであることを示す X-Requested-With ヘッダーを付与し、トークンを X-XSRF-TOKEN ヘッダーに含めることで、Laravel はフォームではなくヘッダーを見て CSRF トークンチェックを行ってくれます。