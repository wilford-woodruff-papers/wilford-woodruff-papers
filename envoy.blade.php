@servers(['web' => ['wilfordw@wilfordwoodruffpapers.org']])

@task('deploy', ['on' => 'web'])
    cd /home/wilfordw/dev.wilfordwoodruffpapers.org/laravel
    php artisan migrate --force
@endtask
