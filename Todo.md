# Install new dependencies if any

    composer install --no-dev --optimize-autoloader

# Apply DB migrations

    php bin/console doctrine:migrations:migrate

# Clear and warmup cache (optional but good)

    php bin/console cache:clear
    php bin/console cache:warmup

# Create your admin user

    php bin/console app:create-admin-user


# Add admin user

Run :

    php bin/console app:create-admin-user
