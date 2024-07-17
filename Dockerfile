# Utiliser une image de base officielle Nginx
FROM nginx:latest
COPY ./index.html /usr/share/nginx/html/index.html

# Utiliser une image de base officielle PHP avec Apache
FROM php:8.2.18-apache

# Définir le répertoire de travail à l'intérieur du conteneur
WORKDIR /var/www/html

# Installer Node.js et npm
RUN apt-get update && \
    apt-get install -y curl && \
    curl -fsSL https://deb.nodesource.com/setup_16.x | bash - && \
    apt-get install -y nodejs

# Installer les extensions PHP nécessaires et les outils de base
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql mysqli gd exif xml

# Copier les fichiers de l'application dans le répertoire de travail
COPY . /var/www/html

# Installer les dépendances JavaScript avec npm
RUN cd /var/www/html && npm install

# Configurer Apache pour autoriser l'écrasement des fichiers .htaccess
RUN a2enmod rewrite

# Définir ServerName pour Apache
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exposer le port 80 pour le serveur web
EXPOSE 80

# Démarrer Apache en premier plan (afin que le conteneur reste actif)
CMD ["apache2-foreground"]

