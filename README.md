# Тестовое задание
Даны два списка. Список автомобилей и список пользователей.
C помощью laravel сделать api для управления списком использования автомобилей пользователями.
В один момент времени 1 пользователь может управлять только одним автомобилем.
В один момент времени 1 автомобилем может управлять только 1 пользователь.

Развёртывание проекта для linux:
- git clone https://github.com/meepozZza/carsharing-test.git
- cd ./carsharing-test/docker
- docker network create carsharing.backend
- docker-compose up -d --force --build
- docker exec -it carsharing.php-fpm bash
- php artisan migrate --seed

Локальный адрес проекта: https://carsharing.localhost/

Документация: https://carsharing.localhost/api/documentation/
