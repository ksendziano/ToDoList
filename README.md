h1 ToDoList
Для запуска требуется docker

Клонируйте проект вместе с модулем:
```bash
git clone --recursive https://github.com/chaconinc/MainProject
```
Выполните команду:
```
composer install
```

В папке проекта копируйте .env.exampleв .env:
```bash
cp .env.example .env
```

Откройте .env файл вашего проекта и установите следующее:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=root
DB_PASSWORD=root
```

Войдите в папку laradock и переименуйте env-exampleв .env.:
```bash
cp env-example .env
```
Откройте .env файл папки laradock и установите следующее:
```
MYSQL_VERSION=8.0
MYSQL_DATABASE=app
MYSQL_USER=root
MYSQL_PASSWORD=root
MYSQL_PORT=3306
MYSQL_ROOT_PASSWORD=root
MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d
```

Запустите необходимые контейнеры:
```bash
docker-compose up -d nginx mysql phpmyadmin workspace
```
Для запуска предварительно создайте базу данных app и выполните миграцию
```bash
docker-compose exec workspace bash
```
```bash
php artisan migrate
```

Для запуска тестов, в workspace используйте команду:
```bash
phpunit
```
