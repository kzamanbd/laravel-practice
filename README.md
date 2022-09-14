# Laravel App

![laravel](https://laravel.com/assets/img/components/logo-laravel.svg)

## Contributing

1. Clone Repository
2. Run command `composer install`
3. Copy `env. example file`, and rename .env
4. Then Run command `php artisan key:generate`
5. Then Run command `php artisan migrate`
6. Then Run command `php artisan db:seed`

## Required Permissions

If you are facing any issues regarding the permissions, then you need to run the following command in your project directory:

```sh
sudo chmod -R o+rw bootstrap/cache
sudo chmod -R o+rw storage
```

## Developed by Zaman

![Zaman](https://assets.gitlab-static.net/uploads/-/system/user/avatar/7189772/avatar.png?width=90)
