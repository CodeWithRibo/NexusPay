#!/bin/bash

echo "Starting NexusPay custom Nginx configuration..."

# 1. Backup the original config
cp /etc/nginx/sites-available/default /etc/nginx/sites-available/default.bak

# 2. Update the root path to /public
sed -i 's|root /home/site/wwwroot;|root /home/site/wwwroot/public;|g' /etc/nginx/sites-available/default

# 3. Fix Laravel/Inertia routing (try_files)
sed -i 's|try_files $uri $uri/ =404;|try_files $uri $uri/ /index.php?$query_string;|g' /etc/nginx/sites-available/default

# 4. Reload Nginx to apply changes
service nginx reload

echo "Nginx reloaded successfully!"

