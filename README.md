## USAGE

```
$ composer install
$ cp .env.example .env
$ php artisan migrate
$ php artisan db:seed
$ php -S localhost:8000 -t ./public
```

## AVAILABLE ROUTES

```
DELETE /logout
GET /user
PUT /user/password
GET /users
GET /users/{id}
PUT /auth/refresh
POST /register
DELETE /logout

POST /events
PUT /events/{id}
GET /events/{id}
GET /events
GET /destiny
GET /destiny/{id}/events

```