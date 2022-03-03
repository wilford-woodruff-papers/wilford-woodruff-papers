@servers(['web' => ['wilfordw@wilfordwoodruffpapers.org']])

@task('test', ['on' => 'web'])
    cd /home/wilfordw/dev.wilfordwoodruffpapers.org/production
    git pull origin main --ff-only
    composer install
    php artisan migrate --force
@endtask

@task('dev', ['on' => 'web'])
    cd /home/wilfordw/dev.wilfordwoodruffpapers.org/develop
    git pull origin develop --ff-only

    composer install --ignore-platform-reqs
    ea-php80 artisan migrate --force
    ea-php80 artisan route:cache
@endtask

@task('prod', ['on' => 'web'])
    cd /home/wilfordw/production_laravel_app

    git pull origin main --ff-only

    cp -R /home/wilfordw/production_laravel_app/public/css/* /home/wilfordw/public_html/css
    cp -R /home/wilfordw/production_laravel_app/public/js/* /home/wilfordw/public_html/js
    cp -R /home/wilfordw/production_laravel_app/public/img/* /home/wilfordw/public_html/img
    cp -R /home/wilfordw/production_laravel_app/public/files/* /home/wilfordw/public_html/files
    cp -R /home/wilfordw/production_laravel_app/public/favicon/* /home/wilfordw/public_html/favicon
    cp -R /home/wilfordw/production_laravel_app/public/vendor/* /home/wilfordw/public_html/vendor

    composer install --ignore-platform-reqs --no-dev
    ea-php80 artisan migrate --force
    ea-php80 artisan route:cache
@endtask
