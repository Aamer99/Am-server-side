## Technologies

* PHP ^8.1
* Laravel ^10 
* MySQL 
* Docker

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

know we need to install the draft server [Follow this link](https://github.com/Aamer99/AM/tree/main/DraftServer)
