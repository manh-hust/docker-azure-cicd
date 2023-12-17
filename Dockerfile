FROM php:8.0.20

RUN curl -sS https://getcomposer.org/installer | php -- \
     --install-dir=/usr/local/bin --filename=composer

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y zlib1g-dev \
    libzip-dev \
    unzip

RUN docker-php-ext-install pdo pdo_mysql sockets zip

RUN mkdir /app

ADD . /app

WORKDIR /app

RUN composer install

RUN cp .env.example .env && php artisan key:generate

# CMD php artisan serve --host=0.0.0.0 --port=8000

EXPOSE 8000

# Expose SSH port
EXPOSE 22

# Install SSH server
RUN apt-get install -y openssh-server

RUN echo "root:Docker!" | chpasswd
RUN ssh-keygen -A

COPY ./sshd_config /etc/ssh/.
EXPOSE 2222 80

COPY ./start.sh start.sh
RUN chmod +x ./start.sh

# Start SSH server
CMD ./start.sh && php artisan serve --host=0.0.0.0 --port=8000
