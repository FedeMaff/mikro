# mikro
**A PHP microservice ready for implementation**

**Mikro** is a package written in **PHP** designed for developers coming from the lamp stack,

**Mikro** is a **ready-to-use architecture**, perfect for the realization of any microservice. The ecosystem is based on 3 types of entrances:

- HTTP input ( _Http Request_ )
- AMQP entrance ( _Eventi Amqp_ )
- CLI input ( _Comandi script bash / terminal_ )

A structured routing system allows a **Mikro** to find the perfect controller implementation for each type of request. A recognition key system allows the developer to create controllers and consumable modules via REST FULL API with minimal effort.

## Installation
It is recommended to install the Mikro dependency through composer as below.

`
$ composer require m4ffucci/mikro
`

## Requests?
The documentation is being drafted, for information and / or news you can write to me at m4ffucci@gmail.com


## Dev
By installing the DEV dependencies you can check the PSR12 encoding standard as well:

$ ./vendor/bin/phpcs --standard=PSR12 ./src

Or you can run the auto-fix like this:

$ ./vendor/bin/phpcbf --standard=PSR12 ./src