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

# Create SSH directory
RUN mkdir /var/run/sshd

# Set up a simple password for the root user (change this for production)
RUN echo 'root:password' | chpasswd

# Allow root login via SSH (change this for production)
RUN sed -i 's/PermitRootLogin prohibit-password/PermitRootLogin yes/' /etc/ssh/sshd_config

# Start SSH server
CMD service ssh start && php artisan serve --host=0.0.0.0 --port=8000
