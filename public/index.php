<?php

if( !session_id() ) @session_start();

require '../vendor/autoload.php';
use DI\ContainerBuilder;
use Delight\Auth\Auth;

$containerBuilder = new ContainerBuilder;
$containerBuilder->addDefinitions([
  Engine::class => function() {
    return new Engine('../app/views');
  },
  PDO::class => function() {
    $driver = 'mysql';
    $host = 'localhost';
    $database_name = 'app3';
    $charset = 'utf8';
    $username = 'root';
    $password = '';
    
    return new PDO("$driver:host=$host;dbname=$database_name;charset=$charset;", $username, $password);
  },
  Auth::class => function($container) {
    return new Auth($container->get('PDO'));
  }
]);
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/home', ['App\controllers\HomeController', 'index']);
    $r->addRoute('GET', '/about', ['App\controllers\HomeController', 'about']);
    $r->addRoute('GET', '/auth', ['App\controllers\HomeController', 'auth']);
    $r->addRoute('POST', '/login', ['App\controllers\HomeController', 'login']);
    $r->addRoute('GET', '/logout', ['App\controllers\HomeController', 'logout']);
    $r->addRoute('GET', '/verification', ['App\controllers\HomeController', 'email_verification']);
    // {id} must be a number (\d+)
    $r->addRoute('GET', '/post/{id:\d+}', ['App\controllers\HomeController', 'post']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404';
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        echo "метод не разрешен";
        d($httpMethod);die;
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $cont = $container->call($routeInfo[1], $routeInfo[2]);
    
        // ... call $handler with $vars
        break;
}
