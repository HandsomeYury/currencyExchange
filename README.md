Запуск<br>
<b>Docker build</b>

Миграции
php bin/console doctrine:migrations:migrate

Пример конвертера на Coindesk
php bin/console app:currency:convert 1 USD BTC

Импорт в базу. Технически можно сколько угодно запускать, но рассчитана на единоразовый запуск
php php bin/console app:quote:import

Простейшая страница с селекторами и пришедшим json'ом
http://localhost/convert
