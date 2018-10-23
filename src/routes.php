<?php

use Framy\Http\Response;

require_once __DIR__ . '/../init.php';

$router = $app->getRouter();

$router->get('/', 'Home:postView')->addMiddleware('Test');
$router->post('/test', 'Home:postTest');
$router->get('/demo/test/[i]:id', 'Home:index')->addMiddleware('Demo');
$router->get('/:id/:id2', function($id, $id2){ return (new Response('test', '200'))->get(); });