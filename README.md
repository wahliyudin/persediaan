composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate


composer require santigarcor/laratrust
php artisan vendor:publish --tag="laratrust"
php artisan laratrust:setup
composer dump-autoload
php artisan migrate
