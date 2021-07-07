Команды для запуска локально:

1) cp .env.example .env  // (если запускать не локально, то изменить переменные в env)

2) composer install

3) sail up -d

4) sail artisan migrate:fresh --seed  // выполнить миграции и сидер

5) sail artisan orchid:admin admin admin@admin.com password  // добавить пользователя для админки, admin@admin.com password (логин пароль)

6) sail npm install

7) sail npm run prod  // собрать фронт

8) sail artisan books:update  // консольная команда для получения и обновления книг



Некоторая информация:

url с тестовым сайтом : https://positron.lightcode.tech

https://positron.lightcode.tech/admin - открывается админка (admin@admin.com password)


Для отправки email в env нужно заполнить данные, в контроллере формы (FeedbackController) закоментирована отправка по email

Настройки добавляются сидером, данные настройки ищуться по полю code в базе данных.

Пользователь для админки добавляется командой, которая есть выше.

Картинки для книг хранятся на сервере, с помощью консольной команды загружаются и обновляются асинхронно.
