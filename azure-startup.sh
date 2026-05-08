#!/bin/bash

# 1. Force Nginx to use the correct port and Laravel root
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

# 2. Re-verify PHP configuration (ensure it listens on 9000)
# Some images require PHP to bind to 0.0.0.0 to talk to Nginx
sed -i 's|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g' /usr/local/etc/php-fpm.d/www.conf 2>/dev/null

# 3. Restart both services to clear the "Bad Gateway"
service php-fpm restart 2>/dev/null || service php8.2-fpm restart
service nginx restart

# 4. Final check: Run Laravel artisan to see if PHP is healthy
php /home/site/wwwroot/artisan about
