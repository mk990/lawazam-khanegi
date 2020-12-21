<?php

use App\Action\HomeAction;
use App\Action\UserCreateAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function (App $app) {
    $app->get('/', function (Request $request, Response $response, $args) {
        return $this->get('view')->render($response, 'app.twig', [
            'name' => $args['name']
        ]);
    })->setName('home');
//    $app->post('/users', UserCreateAction::class);
};
