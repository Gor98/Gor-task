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
### After your docker is ready migrate database

```
docker-compose exec app-core /bin/bash
php artisan migrate
```
### To run tests
```
php artisan test
```