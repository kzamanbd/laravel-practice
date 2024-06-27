@echo off
cd /d "C:\laragon\www\laravel.practice"
echo Starting the queue worker...
php artisan queue:work
