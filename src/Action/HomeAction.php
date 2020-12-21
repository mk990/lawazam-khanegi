<?php

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class HomeAction
{
    public function __construct()
    {
    }

    public function __invoke(Request $request, Response $response,$args): Response
    {
        return $this->get('view')->render($response, 'index.twig', [
            'name' => $args['name']
        ]);

        $response->getBody()->write(json_encode(['success' => true]));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
