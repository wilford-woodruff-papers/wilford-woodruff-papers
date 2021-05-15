@servers(['web' => ['-A wilfordw@wilfordwoodruffpapers.org']])

@task('deploy', ['on' => 'web'])
    cd /home/wilfordw/dev.wilfordwoodruffpapers.org/production
    git pull origin main
    php artisan migrate --force
@endtask
