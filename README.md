# Gor Task

### Clone project from Github
```
git clone https://github.com/Gor98/Gor-task.git
```
### Move to project and copy .env file
#### here are all needed key in real life we do not do this 
#### I put them here for simplicity
```
cd Gor-task && cp env.example .env
```
### Next let docker create environment for you 
#### our container are
* app-core - workspace where our files located
* app-db - MySql database
* app-webserve - nginx webserver
* ngrok - socket to make telegram webhook call our app
```
docker-compose up
```
### Create Telegram bot and put token in .env 
```
docker-compose exec app-core /bin/bash
TELEGRAM_BOT_TOKEN=<YOUR TOKEN>
```
### Open ngrok and get webhook url and update webhook url in .env
```
docker-compose exec app-core /bin/bash
http://0.0.0.0:4040/inspect/http
TELEGRAM_WEBHOOK_URL=<YOUR TOKEN>
```

### After your docker is ready migrate database
```
docker-compose exec app-core /bin/bash
php artisan migrate
```
### Then run command to create webhook
```
php artisan app:create-telegram-webhook
```
### You may check webhook status and if see any error may delete and create new one
```
php artisan app:telegram-webhook-status
php artisan app:remove-telegram-webhook
```
### To run tests
```
php artisan test
```