# ZEGEL | Backend API Sales

Proyecto backend de ejemplo para la clase. Curso de Integración de aplicaciones Backend

## Pasos para su uso

1. ``` git clone https://github.com/jronaldcll/zegel-sales-backend.git ```
2. ``` docker-compose exec app composer install ```
3. Copy ```src/.env.example``` to ```src/.env```
4. ```docker compose up -d --build```
5. ```docker-compose exec app php artisan migrate:fresh --seed```
6. Revisar en el nagegador => ```127.0.0.1:8080```
