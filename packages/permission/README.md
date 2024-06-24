# Laravel App

![laravel](https://laravel.com/assets/img/components/logo-laravel.svg)

## Features

- Authentication (Breeze)
- Authorization
- CRUD Operations
- CRUD Operations with API
- Excel Import/Export(With Queue)
- PDF Generate
- Mail Send
- Notification Send
- Queue
- Event
- Listener
- Dockerize Application
- Scale Application

## Run Application Or Contributing

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

## Dockerize Application

To run the application in docker container

```bash
docker-compose up -d --build
```

## Run Application Scale Mode

To run the application in scale mode

```bash
docker-compose up -d --build --scale laravel-app=3
```

## Show Application container Logs

To show the application container logs

```bash
docker logs -f <container-name>
```

## Developed by Zaman

![Zaman](https://assets.gitlab-static.net/uploads/-/system/user/avatar/7189772/avatar.png?width=90)
