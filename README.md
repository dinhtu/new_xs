# go to project
$ git clone https://github.com/wataru1021/proof_service.git backend
$ git {backend}
$ git remote
$ git push origin main

# install app's dependencies
$ composer install

# install app's dependencies
$ npm install

### Next step

``` bash
# in your app directory
# generate laravel APP_KEY
$ php artisan key:generate

# run database migration and seed
$ php artisan migrate:refresh --seed

# generate mixing
$ npm run dev or npm run build

# and repeat generate mixing
$ npm run dev
