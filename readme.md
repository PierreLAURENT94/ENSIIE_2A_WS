# Web Services : Midterm test

![](/projet.png)

## REST -> [http://localhost:8000/](http://localhost:8000/)

### Requirements
* Composer
* Symfony CLI
* PHP 8.2.4
* MySQL / MariaDB

### Set in .env file
* the COMPANY
* the DATABASE_URL

### In \public\bundles\apiplatform\
* Drop the good *logo-header.svg*

### Run in the terminal
```
composer install
php bin/console d:d:d --force
php bin/console d:d:c
php bin/console d:m:mi
php bin/console d:fix:load

symfony server:start --port=8000
```

## SOAP -> [http://localhost/server.php?wsdl](http://localhost/server.php?wsdl)

### Requirements
* Apache
* PHP 8.2.4
* MySQL / MariaDB

### Enable soap extension in php.ini file

### Execute sql code from init.sql

### Put the server.php and test.wsdl in the apache web folder

## Client -> [http://localhost/client/Rechercher_un_train.html](http://localhost/client/Rechercher_un_train.html)

### Requirements
* Apache
* PHP 8.2.4
* MySQL / MariaDB

### Enable soap extension in php.ini file

### Put the client folder in the apache web folder

### Put the content of the client folder in the apache web folder

### Put the client.php of soap folder in the apache web folder

### Comment all after line 76 in client.php