## Technologies

* PHP ^8.1
* Laravel ^10 
* MySQL 
* Docker
* Redis

  first you need to install redis 

## Install Redis 
Go to the project directory
```bash
  cd my-project
```
Install Redis

```bash 
composer require predis/predis
```
Setup Redis on the env 

```bash 
BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=redis
SESSION_DRIVER=file
SESSION_LIFETIME=120
```
for more information about how to install Redis on docker [Link](https://hub.docker.com/_/redis) 

##  Install Horizon
To install, run the following command

```bash
composer require laravel/horizon
```
 Publish its assets using the horizon:install Artisan command: 
```bash 
php artisan horizon:install 
```

## Setub the email configuration
for the email go to the [mailtrap](https://mailtrap.io/) and create an account after that take the configuration values and put them on the env file 

```bash 
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=*******
MAIL_PASSWORD=********
MAIL_ENCRYPTION=tls
```
## Create Database 

after setup the email know you need to create the database and set it to the env 

```bash 
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```  
after that, we need to migrate all the tables by writing this command.
 
```bash
php artisan migrate
```

know you can run the server by writing this command. 

```bash
php artisan serve
```
final step run the queue bt writing this command 
``` bash 
php artisan queue:work 
```

know we need to install the draft server [Follow this link](https://github.com/Aamer99/Am-server-side/tree/main/DraftServer)
