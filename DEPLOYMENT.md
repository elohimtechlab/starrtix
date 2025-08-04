# StarrTix Deployment Guide

## Git-Based Deployment Workflow

This guide explains how to deploy updates from your local development environment to the live server using Git.

## Prerequisites

- Git installed on both local machine and live server
- SSH access to your live server
- Remote Git repository (GitHub, GitLab, etc.)

## Initial Setup

### 1. Local Development Setup ✅
- [x] Local environment configured
- [x] Database imported and working
- [x] Application running at `http://localhost/starrtixapp`

### 2. Git Repository Setup

```bash
# Initialize Git repository
git init

# Add all files
git add .

# Initial commit
git commit -m "Initial commit - StarrTix local development setup"

# Add remote repository
git remote add origin https://github.com/elohimtechlab/starrtix.git

# Push to remote
git push -u origin main
```

### 3. Live Server Setup

On your live server, navigate to your web directory and clone the repository:

```bash
# Clone the repository
git clone https://github.com/elohimtechlab/starrtix.git /path/to/your/web/directory

# Navigate to project directory
cd /path/to/your/web/directory

# Copy production environment file
cp .env.example.production .env

# Install dependencies
composer install --no-dev --optimize-autoloader

# Set permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Daily Development Workflow

### Making Changes Locally

1. **Make your changes** in `/Applications/MAMP/htdocs/starrtixapp`
2. **Test locally** at `http://localhost/starrtixapp`
3. **Commit changes**:
   ```bash
   git add .
   git commit -m "Description of your changes"
   ```
4. **Push to remote**:
   ```bash
   git push origin main
   ```

### Deploying to Live Server

#### Option A: Manual Deployment
SSH into your live server and run:
```bash
cd /path/to/your/web/directory
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan cache:clear
```

#### Option B: Using Deployment Script
1. Upload `deploy.sh` to your live server
2. Make it executable: `chmod +x deploy.sh`
3. Run: `./deploy.sh`

## Environment Files

- **`.env`** - Local development (already configured)
- **`.env.example.production`** - Template for production
- **Live server `.env`** - Copy from `.env.example.production` and customize

## Important Notes

- **Never commit `.env` files** - They're in `.gitignore`
- **Always test locally first** before deploying
- **Backup your live database** before major updates
- **Use `--force` flag for migrations** on production (be careful!)

## Troubleshooting

### Common Issues:
- **Permission errors**: Run `chmod -R 755 storage bootstrap/cache`
- **Cache issues**: Run `php artisan cache:clear`
- **Config issues**: Run `php artisan config:cache`

### Emergency Rollback:
```bash
git log --oneline  # Find previous commit hash
git reset --hard <previous-commit-hash>
git push --force origin main  # Use with caution!
```

## Security Checklist

- [ ] `.env` files are not in version control
- [ ] Production has `APP_DEBUG=false`
- [ ] Database credentials are secure
- [ ] File permissions are properly set
- [ ] SSL certificate is active
