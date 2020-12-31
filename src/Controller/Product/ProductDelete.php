<?php

namespace App\Controller\Product;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class ProductDelete extends BaseController
{
    /**
     * @return Response
     */
    protected function action(): Response
    {
        $stmt = $this->db->prepare("Delete FROM products  WHERE id=:id");
        $stmt->bindParam(':id', $this->args['id'], 1);
        if ($stmt->execute())
            return $this->redirectTo('/');
        return $this->errorMessage('error');
    }

}
