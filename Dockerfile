FROM rpungello/laravel-franken:8.4

ARG VERSION=1.0.0
ENV APP_VERSION=${VERSION}
ENV APP_NAME="PDF Backup"
COPY . /app
RUN composer install && npm install && npm run build \
 && chown -R www-data:www-data /app \
 && echo "upload_max_filesize = 16M" > /usr/local/etc/php/conf.d/uploads.ini \
 && echo "post_max_size = 32M" >> /usr/local/etc/php/conf.d/uploads.ini

HEALTHCHECK --interval=5s --timeout=3s --retries=3 CMD php artisan status
