# 1. استخدم صورة PHP مع Apache
FROM php:8.2-apache

# 2. تثبيت الأدوات المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# 3. نسخ جميع ملفات المشروع
WORKDIR /var/www/html
COPY . .

# 4. تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. تثبيت حزم المشروع
RUN composer install --no-dev --optimize-autoloader

# 6. صلاحيات مجلدات Laravel المهمة
RUN chmod -R 775 storage bootstrap/cache

# 7. تشغيل السيرفر
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
