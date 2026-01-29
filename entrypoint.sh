#!/bin/bash

echo "[+] Fixing upload permissions..."

mkdir -p /var/www/html/uploads

chown -R www-data:www-data /var/www/html/uploads
chmod -R 777 /var/www/html/uploads

# Optional: allow log poisoning labs
mkdir -p /var/log/apache2
chmod -R 777 /var/log/apache2

echo "[+] Starting Apache..."
exec apache2-foreground
