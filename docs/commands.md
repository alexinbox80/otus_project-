docker-compose up -d \
docker exec -it php sh

#make new entity \
php bin/console make:entity

#create migrations \
php bin/console doctrine:migrations:diff

#migrate migrations \
php bin/console doctrine:migrations:migrate

#clear cache \
php bin/console cache:clear
php bin/console cache:pool:clear cache.system_clearer


#show route lists \
php bin/console debug:router

#schema validate \
php bin/console doctrine:schema:validate \
doctrine:schema:update --dump-sql

#drop all tables in database \
php bin/console doctrine:schema:drop --full-database --force