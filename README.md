# retailcrm-clients
Тестовое задание для RetailCRM

## Деплой и запуск проекта

 - Создать файл .env в корне проекта со следующим содержимым:
 
 ```
APP_ENV=dev
APP_SECRET=0eea37772f8e514d61e518a3e22a7243

DATABASE_URL=postgresql://retailcrm:password@db:5432/retailcrm-clients?serverVersion=12&charset=utf8
```

 - Выполнить команды:

```
docker-compose up -d
docker-compose exec php composer install && yarn install && yarn build
docker-compose exec php php bin/console doctrine:migrations:migrate
docker-compose exec php php bin/console doctrine:fixtures:load
```

Точка входа http://clients.retailcrm.localhost:8088/
