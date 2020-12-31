<?php

namespace App\Controller\Product;

use App\Controller\BaseController;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;
use Slim\Exception\HttpNotFoundException;

final class ProductGetUpdate extends BaseController
{
    /**
     * @return Response
     * @throws Exception
     */
    protected function action(): Response
    {
        $stmt = $this->db->prepare('SELECT * FROM products where id=:id');
        $stmt->bindParam(':id', $this->args['id']);
        $stmt->execute();
        $product = $stmt->fetch();
        return $this->view('update.twig', ['product' => $product]);
    }
}
