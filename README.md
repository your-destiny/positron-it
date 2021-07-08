## Команды для запуска локально с помощью docker:

#### 1) cp .env.example .env  // (если запускать не локально, то изменить переменные в env)


#### 2) composer install


#### 3) ./vendor/bin/sail up -d


#### 4) ./vendor/bin/sail artisan migrate:fresh --seed  // выполнить миграции и сидер


#### 5) ./vendor/bin/sail artisan orchid:admin admin admin@admin.com password  // добавить пользователя для админки, admin@admin.com password (логин пароль)


#### 6) ./vendor/bin/sail npm install


#### 7) ./vendor/bin/sail npm run prod  // собрать фронт


#### 8) ./vendor/bin/sail artisan books:update  // консольная команда для получения и обновления книг

## Некоторая информация:


Для отправки email в env нужно заполнить данные, в контроллере формы (FeedbackController) закомментирована отправка по email

Настройки добавляются сидером, данные настройки ищутся по полю code в базе данных.

Пользователь для админки добавляется командой, которая есть выше.

Картинки для книг хранятся на сервере, с помощью консольной команды загружаются и обновляются асинхронно.
