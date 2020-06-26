# Project PHP Symfony schedule app
# Install
Create local database with preferences name and adjust settings in .env
Go to folder app and run:
```
composer install
```
```
bin/console doctrine:migrations:migrate
```
```
bin/console doctrine:fixtures:load
```
```
bin/console server:run
```
# Default logins / passwords:
Admin
```
login: admin0@example.com
password: admin1234
```
User
```
login: user0@example.com
password: user1234
```
There are 3 admin & 10 user accounts (just increase number in login to change account)
