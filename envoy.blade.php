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
    composer install
    php artisan migrate --force
@endtask

@task('prod', ['on' => 'web'])
    cd /home/wilfordw/production_laravel_app
    git pull origin main --ff-only
    
    composer install
    php artisan migrate --force
@endtask
