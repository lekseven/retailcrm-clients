# retailcrm-clients
Тестовое задание для RetailCRM

## Деплой и запуск проекта

```
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php doctrine:migrations:migrate
docker-compose exec php php bin/console doctrine:fixtures:load
```
