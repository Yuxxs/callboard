# CallBoard
[Source code](https://github.com/Yuxxs/callboard)
## Requirements
    * Docker version 18.06 or later
    * Docker compose version 1.22 or later
    
    
    Note: OS recommendation - Linux Ubuntu based.

## Components
    1. Nginx:alpine
    2. PHP 7.4 fpm
    3. Postgres 12:alpine
    4. Laravel 8
    5. Mailhog
    6. RabbitMQ
## Setting up environment
    1.Clone this repository from GitHub.
    2.Edit .env and set necessary user/password for Postgres.
    3.Run make deploy.
    4.Run make migrate.
    5.Run make seed. 

## Start and stop environment
Please use next make commands in order to start and stop environment:
    
    make start
    make stop

Tested on Ubuntu 20.04
Running on 0.0.0.0:8000
