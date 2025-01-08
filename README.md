参考サイト
https://zenn.dev/eguchi244_dev/articles/laravel-and-docker-introduction-20230822

default.confの
root /var/www/<Laravelのプロジェクト名>/public;
を変えないとエラーが出る

docker起動

docker起動時に以下のエラーが起きた場合
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

Laravelをインストールする
composer create-project "laravel/laravel=9.*" <Laravelのプロジェクト名>
