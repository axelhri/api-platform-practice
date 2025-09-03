docker compose up -d

composer install

docker exec -it symfony_php php bin/console doctrine:database:create

docker exec -it symfony_php php bin/console doctrine:migrations:migrate

docker exec -it symfony_php php bin/console doctrine:fixtures:load

docker exec -it symfony_php php bin/console doctrine:database:create --env=test

docker exec -it symfony_php php bin/console doctrine:migrations:migrate --env=test

docker exec -it symfony_php php bin/console doctrine:fixtures:load --env=test
