# Utiliser l'image officielle PHP comme base
FROM php:8.1-cli

# Mettre à jour les paquets et installer les dépendances nécessaires pour Node.js
RUN apt-get update && apt-get install -y \
    curl \
    gnupg2 \
    lsb-release \
    ca-certificates \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Vérifier que Node.js et npm sont installés
RUN node -v && npm -v

# Définir le répertoire de travail dans le conteneur
WORKDIR /var/www/html

# Copier les fichiers de votre application (si vous avez des fichiers locaux à copier)
# COPY . /var/www/html/

# Commande par défaut (si vous avez un serveur web ou autre processus à lancer)
# CMD ["php", "-S", "0.0.0.0:80", "-t", "/var/www/html"]
