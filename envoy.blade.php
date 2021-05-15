@servers(['web' => ['wilfordw@wilfordwoodruffpapers.org']])

@task('dev', ['on' => 'web'])
    cd /home/wilfordw/dev.wilfordwoodruffpapers.org/production
    git pull origin main --ff-only
    composer install
    php artisan migrate --force
@endtask
