#!/bin/bash

echo "Starting NexusPay custom deployment sequence..."

# 1. Overwrite Nginx to use TCP Port 9000 (found in your www.conf)
cat <<EOF > /etc/nginx/sites-available/default
server {
    listen 80;
    listen [::]:80;
    root /home/site/wwwroot/public;
    index index.php index.html index.htm;
    server_name _;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }
}
EOF

# 2. Fix Permissions (Crucial for 502/500 errors)
chown -R www-data:www-data /home/site/wwwroot/storage /home/site/wwwroot/bootstrap/cache
chmod -R 775 /home/site/wwwroot/storage /home/site/wwwroot/bootstrap/cache

# 3. Restart Services
# We try multiple service names because Azure images vary
service php-fpm restart || service php8.2-fpm restart
service nginx restart

# 4. Clear Laravel Cache to prevent old config issues
php /home/site/wwwroot/artisan config:clear
php /home/site/wwwroot/artisan view:clear

echo "Deployment sequence complete!"
