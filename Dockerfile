FROM wordpress:php7.2-apache

# Set working directory
WORKDIR /var/www/html

# Copy all WordPress files from repository
COPY . /var/www/html/

# Set proper permissions for WordPress
# www-data is the default user for WordPress in the official image
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    find /var/www/html -type f -exec chmod 644 {} \;

# Ensure wp-content/uploads is writable (will be overridden by volume mount in production)
RUN chmod -R 775 /var/www/html/wp-content/uploads

# Expose port 80
EXPOSE 80

# Use the default WordPress entrypoint
# The wordpress:php7.2-apache image already has the proper entrypoint configured
