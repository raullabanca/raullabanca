How to install:

1. Go into the project's folder
2. Setup Mysql and the "app/config/parameters.yml"
3. Execute composer install
4. Execute "php bin/console doctrine:database:create"
5. Execute "php bin/console doctrine:schema:update --force"
6. Execute "php bin/console server:run"

People GET:
api/people
api/person/{id}

Shiporders GET:
api/shiporders
api/shiporder/{id}
