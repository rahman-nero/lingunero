## Документация


### Запуск

Запуск не сложен, но требует некоторых содействий от вас. 

Шаги которые нужно сделать:
* Настроить docker-compose.yaml
* Установить composer-зависимости
* Настроить .env-файл
* Установить npm-зависимости
* Запуск миграций
* еще мелкие действия


**Шаг 1. Настройка docker-compose.yml**

Настроить docker-compose.yml нам особо не нужно, только нужно изменить один параметр.
Заходим в `docker-compose.yml`, дальше нам нужно вправить два сервиса: **php-fpm** и **php-cli**.

В них нам нужно поменять два параметра: `args -> WWWUSER` и в `user:`.

В эти параметры нам нужно вписать имя твоего компьютера (можно узнать командой whoami в консоли):
```
   args:
       WWWUSER: 'user' <- сюда пишем имя твоего компа
        
   user: 'user' <- сюда пишем имя твоего компа
```

И эти действия нужно проделать для обоих сервисов: **php-cli** и **php-fpm**

Чтобы выполнить последующие действия, нам нужно запустить контейнеры:
```
    make docker-up
```


**Шаг 2. Установка composer-зависимостей:**

Чтобы установить зависимости выполняем, вот эти команды:
```
    docker-compose exec php-cli composer install 
```


**Шаг 3. Настроить .env-файл :**

Смотри, у тебя в проекте есть файл .env.example - это примерный файл конфига.
Нам теперь нужно переименовать этот файл в .env

В этом файле вы должны указать заполнить поле `APP_KEY`, это не делается вручную, для этого есть команда
```
    docker-compose exec php-cli php artisan key:generate 
```
Также если вы запустили сайт не на localhost, а на каком-то домене. 
То тогда, меняем параметр `APP_URL` в конфиге, на тот адресс который вы указали.
Мы закончили с настройкой .env-файла


**Шаг 4.  Установить npm-зависимости**

Чтобы установить эти зависимости, делаем просто `npm install`. Тут есть одна загвоздка, поидеи, я должен был
создать образ и для npm, и запустить его, а потом с помощью образа запустить выше команду. Но я это не сделал, ибо
просто времени не хватило. Может быть в будущем добавлю новый сервис npm. Поэтому чтобы выполнить выше команду, у тебя 
на компе должен быть `nodejs` и `npm`


**Шаг 5. Запускаем миграций**

Теперь после всех действий нам нужно сделать миграцию базу данных.

```
    docker-compose exec php-cli php artisan migrate
```


**Шаг 6. Мелкие действия**

Команда для создание ссылки на storage в папке public.

```
    docker-compose exec php-cli php artisan storage:link 
```

Дальше заходим на `localhost:8080` и наслаждаемся баном

---
### Бонус.

У меня в папке `backups`, хранятся слова которые я добавил в свою бд, во время изучения английского. 
Если вы хотите запустить приложения с этими данными, то вам нужно импортировать этот файл в бд.
Вот команда которая это делает:
```
mysql -uroot -proot app --port 33006 < backups/<<тут пишем имя файла>>
```

Заметь, чтобы это работало нужны запушенные контейнеры докера.


**Логин и пароль для входа на сайт:**

Первый пользователь:

    email: dikaev016@gmail.com
    password: 89637042231

Второй пользователь:

    email: dikaevr053@gmail.com
    password: 1234567890
