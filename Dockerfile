# Use the official PHP image
FROM php:apache

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy your application files (optional, if you want to add files directly in the image)
# Uncomment the next line and adjust the path to your application
# COPY ./path_to_your_app /var/www/html/

# Ensure the Apache server has the correct permissions (if needed)
RUN chown -R www-data:www-data /var/www/html
