1. Пропишите сопоставление 127.0.0.1 artsofte.local в hosts

2. Запустите докер - docker-compose up -d --build

3. Сделайте composer install

4. Создайте БД - php bin/console doctrine:database:create

5. Примените миграции - php bin/console doctrine:migrations:migrate --no-interaction

6. Загрузите тестовые данные - php bin/console doctrine:fixtures:load

7. Для запуска тестов, используйте php bin/phpunit

URL:

http://artsofte.local/api/doc - API documentation