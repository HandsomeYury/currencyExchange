<h3>Удобный link</h3>
<code>https://github.com/HandsomeYury/currencyExchange.git</code>

<h1>Запуск</h1><br>
<code>docker compose up</code>

<h2>Миграции Symfony</h2>
php bin/console doctrine:migrations:migrate

<h2>Зависимости в ./app</h2>
локально <code>php composer.phar install</code> или в контейнере через <code>docker-compose exec php php...</code> или <code>composer i</code>

<h2>Пример конвертера на Coindesk</h2>
<code>php bin/console app:currency:convert 1 USD BTC</code> или же <code>docker-compose exec php php bin/console app:currency:convert 1 USD BTC</code>

<h2>Импорт в базу</h2>
Ограничений на кол-во запусков нет, но в рамках тестового рассчитан на единоразовый запуск, без оговорок на этот счет. Возможно в реалиях они или по крону обновляться должны, или в редисе лежать, или в любом другом практичном формате

<code>php bin/console app:quote:import</code> или же <code>docker-compose exec php php bin/console app:quote:import</code>

Простейшая страница без <s>окон и дверей</s> билдов js и стилей. И визуально пришедшим json'ом.
http://localhost/convert

Еще есть техническая /testCommand страница для проверки вызова команды в контроллере

<img src="https://static.pepper.ru/threads/raw/tYgMS/383179_1/re/1024x1024/qt/60/383179_1.jpg" />
