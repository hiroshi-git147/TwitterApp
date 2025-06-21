# ベースイメージの指定
FROM php:8.0-fpm

# php.ini をコピー
COPY php.ini /usr/local/etc/php/

# 必要なパッケージとライブラリのインストール
RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        mariadb-client \
        vim \
        libzip-dev \
        curl \
        gnupg \
        unzip \
    && docker-php-ext-install zip pdo_mysql

# Composer のインストール
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

# Composer の環境変数設定
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer
ENV PATH $PATH:/composer/vendor/bin

# Node.js と npm のインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 作業ディレクトリの設定
WORKDIR /var/www

# Laravel Installer のインストール
RUN composer global require "laravel/installer"
