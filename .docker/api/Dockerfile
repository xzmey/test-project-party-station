FROM php:8.1-fpm

#default port 9011
RUN sed -i 's/9000/9011/' /usr/local/etc/php-fpm.d/zz-docker.conf

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    python-is-python3 2to3 \
    unzip \
    libpq-dev \
    npm \
    sudo;

# ext-zip
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN docker-php-ext-install mbstring exif pcntl bcmath gd gettext sockets

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /home/$user/.npm/_logs;
# Install nvm (A Node Version Manager)

# nvm env vars
RUN mkdir -p /usr/local/nvm
ENV NVM_DIR /usr/local/nvm
# IMPORTANT: set the exact version
ENV NODE_VERSION v16.17.0
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.5/install.sh | bash
RUN /bin/bash -c "source $NVM_DIR/nvm.sh && nvm install $NODE_VERSION && nvm use --delete-prefix $NODE_VERSION"
# add node and npm to the PATH
ENV NODE_PATH $NVM_DIR/versions/node/$NODE_VERSION/bin
ENV PATH $NODE_PATH:$PATH
RUN npm -v
RUN node -v

RUN npm install -g @vue/cli;


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user -p pass $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www/api

USER $user
