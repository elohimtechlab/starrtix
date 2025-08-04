#!/bin/bash

# StarrTix Deployment Script
# This script helps deploy updates to the live server

echo "🚀 StarrTix Deployment Script"
echo "=============================="

# Check if we're in the right directory
if [ ! -f "artisan" ]; then
    echo "❌ Error: Not in Laravel project directory"
    exit 1
fi

# Pull latest changes from Git
echo "📥 Pulling latest changes from Git..."
git pull origin main

# Install/Update Composer dependencies (production optimized)
echo "📦 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

# Clear and cache Laravel configurations
echo "🧹 Clearing and caching Laravel configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations (if any)
echo "🗄️ Running database migrations..."
php artisan migrate --force

# Clear application cache
echo "🔄 Clearing application cache..."
php artisan cache:clear

# Set proper permissions
echo "🔐 Setting proper permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

echo "✅ Deployment completed successfully!"
echo "🌐 Your application should now be updated on the live server."
