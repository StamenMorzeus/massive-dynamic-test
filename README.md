# Massive Dynamic Test

## Basic installation

### Prerequisites

what is needed to run an instance of this project:

- Docker
- Docker compose

### Preparations

This app makes uses the [Laravel app framework](https://laravel.com/docs/9.x) with the [Bootstrap 5](https://getbootstrap.com/docs/5.0/getting-started/introduction/) and [Tailwindcss](https://tailwindcss.com/docs/installation)

To start it up, create a local copy of the .env file to match your system within the src/ folder. Afterwards create the initial package installations through [npm](https://docs.npmjs.com/cli/v8/configuring-npm/install) and [composer](https://getcomposer.org/)

### Running

````
$ ./vendor/bin/sail up
$ ./vendor/bin/sail artisan migrate
$ ./vendor/bin/sail artisan db:seed
````

afterwards, the system can be accessed via http://localhost

Administration login credentials:

````
Email: administrator@mail.com
Password: password
````

Secretary login credentials:

````
Email: secretary@mail.com
Password: password
````

### Running Tests

````
$ ./vendor/bin/sail artisan test
````
