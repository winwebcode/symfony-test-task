1. Пропишите сопоставление 127.0.0.1 artsofte.local в hosts

2. Запустите докер - docker-compose up -d --build 

3. Создайте БД - php bin/console doctrine:database:create 

4. Примените миграции - php bin/console doctrine:migrations:migrate --no-interaction

5. Загрузите тестовые данные - php bin/console doctrine:fixtures:load

