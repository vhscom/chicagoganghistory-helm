#!/bin/sh

# install the PHP extensions (from the WP Dockerfile)
set -ex;
savedAptMark="$(apt-mark showmanual)";

apt-get update;
apt-get install -y --no-install-recommends \
	libfreetype6-dev \
	libjpeg-dev \
	libmagickwand-dev \
	libpng-dev \
	libwebp-dev \
	libzip-dev;

docker-php-ext-configure gd \
	--with-freetype \
	--with-jpeg \
	--with-webp \
;
docker-php-ext-install -j "$(nproc)" \
	bcmath \
	exif \
	gd \
	mysqli \
	zip \
;
# https://pecl.php.net/package/imagick
pecl install imagick-3.5.0;
docker-php-ext-enable imagick;
rm -r /tmp/pear;

# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
apt-mark auto '.*' > /dev/null;
apt-mark manual $savedAptMark;
ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
	| awk '/=>/ { print $3 }' \
	| sort -u \
	| xargs -r dpkg-query -S \
	| cut -d: -f1 \
	| sort -u \
	| xargs -rt apt-mark manual;

apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false;
rm -rf /var/lib/apt/lists/*
