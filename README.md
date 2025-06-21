参考サイト
https://zenn.dev/eguchi244_dev/articles/laravel-and-docker-introduction-20230822

default.conf の
root /var/www/<Laravel のプロジェクト名>/public;
を変えないとエラーが出る

docker 起動

docker-compose up --build -d

docker 起動時に以下のエラーが起きた場合
Error response from daemon: Conflict. The container name "/mysql_test" is already in use by container "8de28275cc5cf94786a0c5e05b0a93982448cf0767b941d4369a3eaa596c1b5f". You have to remove (or rename) that container to be able to reuse that name.

1. 既存のコンテナを確認
   docker ps -a
   コンテナー名を探す

2. 既存のコンテナを削除
   docker rm （コンテナ名）

2.5. 既存のコンテナを停止（必要に応じて）
docker stop (コンテナ名)

3. 既存のコンテナを再利用
   docker start (コンテナ名)

コンテナにログインする
docker-compose exec php bash

Laravel をインストールする
composer create-project "laravel/laravel=9.\*" <Laravel のプロジェクト名>

Composer のオートロード設定を変更する
"autoload": {
"psr-4": {
"App\\": "app/",
"App\\Models\\": "app/Models/", # 追加
[中略]
}
},

インストールの確認をする
cd LaravelTestProject
php artisan --version

Laravel プロジェクトのタイムゾーンを JST（日本時間）に変更。
config/app.php
'timezone' => 'UTC',
'timezone' => 'Asia/Tokyo',

プロジェクト直下に laravelLaravel プロジェクトとデータベースを連携
MYSQL_DATABASE: twitter_db
MYSQL_USER: admin
MYSQL_PASSWORD: secret

これらの中身を.env ファイルに記載
