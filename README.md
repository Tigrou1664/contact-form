# Project contact-form
Test d'un formulaire de contact avec backoffice sous Symfony 6.4.1

## Setup

1. Get project files and install them
```shell
# clone the project to download its content
$ cd projects/
$ git clone ...

# make Composer install the projects's dependencies into vendor/
$ cd my-project/
$ composer install
```

2. Set database with your own settings in `.env` file
```shell
#.env or .env.local

DATABASE_URL="mysql://user:password@localhost:3306/app?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
```

3. Execute command to create database
```shell
$ php bin/console doctrine:database:create
```

4. Load fixtures
```shell
$ php bin/console doctrine:fixtures:load
```

5. Start local web server to run project
```shell
$ cd my-project/
$ symfony server:start
```



