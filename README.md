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


## Middleware

It is possible to add [middleware](src/Middleware) to routes with the method `addMiddleware($middlewareName)`


```php
$router->get('/', 'Home:index')->addMiddleware('Test');
```

## Auto-wiring

[Auto-wiring](src/DI) can be used in a controller's constructor like below:


```php
class HomeController extends Controller {

    private $db;
    private $userRepo;

    public function __construct(Database $db, UserRepository $userRepo) {
        $this->db = $db;
        $this->userRepo = $userRepo;
    }
```

## Models (edit & save)

A model can execute an update:

```php
$user = new User($this->db);
$user->name = "Test";
$user->id = 3;
$saveUser = $user->edit($user);
```
or an insert

```php
$user = new User($this->db);
$user->name = "Test";
$saveUser = $user->save($user);
```
