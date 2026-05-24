# Deployment Guide

## Prerequisites
- PHP 8.2+
- MySQL 8.0+
- Composer

## Shared Hosting Steps
1. Upload code to a subfolder (not `public_html`).
2. Symlink `public` folder to `public_html/hrms`.
3. Set `.env` values:
    - `APP_ENV=production`
    - `APP_DEBUG=false`
    - `QUEUE_CONNECTION=database`
4. Run:
    - `composer install --no-dev --optimize-autoloader`
    - `php artisan migrate --force`
    - `php artisan db:seed --class=RolesAndPermissionsSeeder --force`

## Cron Job (Production)
Add this to your server's crontab:
`* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1`

## Queue Worker
On shared hosting, use the scheduler to run `queue:work`:
`$schedule->command('queue:work --stop-when-empty')->everyMinute();`
