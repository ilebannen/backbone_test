# backbone_test

Proyecto de Prueba para backbone

Para instalar usando docker:

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Para levantar el servicio

```
./vendor/bin/sail up
```

Para inicializar la DB y los datos

```
./vendor/bin/sail artisan migrate:refresh
./vendor/bin/sail artisan db:seed
```