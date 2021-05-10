#!/bin/bash

# Allows WP CLI to run with the right permissions.
wp-su() {
    sudo -E -u www-data wp "$@"
}

# Clean up from previous tests
rm -rf /wp-core/wp-content/plugins/ninja-forms


# Make sure permissions are correct.
cd /wp-core
chown www-data:www-data wp-content/plugins
chmod 755 wp-content/plugins

# Make sure the database is up and running.
while ! mysqladmin ping -hmysql --silent; do

    echo 'Waiting for the database'
    sleep 1

done

echo 'The database is ready'

# Make sure WordPress is installed.
if ! $(wp-su core is-installed); then

    echo "Installing WordPress"

    wp-su core install --url=wordpress --title=tests --admin_user=admin --admin_password=password --admin_email=test@test.com

    # The development version of Gravity Flow requires SCRIPT_DEBUG
    wp-su core config --dbhost=mysql --dbname=wordpress --dbuser=root --dbpass=wordpress --extra-php="define( 'SCRIPT_DEBUG', true );" --force
fi

echo 'Updating Database'
wp-su core update-db

echo "Copy Ninja Forms Plugin Directory"
mkdir wp-content/plugins/ninja-forms
cp -r /repo/* wp-content/plugins/ninja-forms/

echo 'Activating Ninja Forms'
wp-su plugin activate ninja-forms

cd /project

exec "/repo/vendor/bin/codecept" "$@"