#!/usr/bin/env bash
npm i

php -d memory_limit=3G /usr/local/bin/composer install

php bin/console fos:js-routing:dump -p --format=json --target=./public/js/fos_js_routes.json

npm run build