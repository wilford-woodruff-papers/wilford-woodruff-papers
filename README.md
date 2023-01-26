<p align="center"><a href="https://wilfordwoodruffpapers.org/img/image-logo.png" width="400"></a></p>

## Getting Started with Development
Clone the Github repository

```git clone https://github.com/wilford-woodruff-papers/wilford-woodruff-papers```

You may wish to configure a shell alias that allows you to execute Sail's commands more easily:

```alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'```

Install PHP dependencies (you need PHP installed to do this)

```composer install```

Copy .env file to the root or your project directory

## Installation and Setup of Sail

```./vendor/bin/sail up``` or if you created the alias ```sail up```

To make sure the packages are correct for the docker version of PHP run composer again

```composer install```

## Import the sample database


## Edit hosts file

OSX ```sudo nano /private/etc/hosts```



## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

