# PHP-Framy

> A simple PHP MVC Framework


## Functionalities
- Routing
- Middleware
- Auto-wiring
- Models (edit & save)
- Query builder
- Request
- Response

## Routing

The [Router](src/Routing/Router.php) makes it possible to define routes and call a controller in relation with a controller method.

GET routes are added with the `get` method and POST routes with `post`.
You can specify the controller and the controller method like below:

```php
$router->get('/', 'Home:index');
$router->post('/test', 'Home:test');
```

Or you can add route **parameters**:

```php
$router->get('/page/:id', 'Home:page');
```
`[i]:id` can be used if the parameter should contain integers only.
<br/>
`[s]:id` can be used to make sure the parameter is a string (optional).
