<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;

final class HomeAction extends BaseController
{
    protected function action(): Response
    {
        $stmt = $this->db->query('SELECT * FROM products');
        $products=$stmt->fetchAll();
        return $this->view('index.twig', [
            'products' => $products,
        ]);
    }
}
