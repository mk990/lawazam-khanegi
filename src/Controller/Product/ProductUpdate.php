<?php

namespace App\Controller\Product;

use App\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

final class ProductUpdate extends BaseController
{
    /**
     * @return Response
     */
    protected function action(): Response
    {
        $parsBody  = $this->request->getParsedBody();
        $validator = v::create()
            ->key('name', v::stringType()->length(1, 100))
            ->key('count', v::number()->min(0)->max(10000))
            ->key('code', v::alnum()->length(1, 100))
            ->key('buy_price', v::number()->min(0)->max(10000000000000000))
            ->key('sell_price', v::number()->min(0)->max(10000000000000000))
            ->key('aed_price', v::number()->min(0)->max(10000000000000000));
        try {
            $validator->assert($parsBody);
        } catch (NestedValidationException $e) {
            return $this->errorMessage('خطا در داده ها', $e->getMessages());
        }

        $stmt = $this->db->prepare("UPDATE products  SET
                                    name=:name, count=:count, code=:code, buy_price=:buy_price, sell_price=:sell_price, aed_price=:aed_price
                                    WHERE id=:id");
        $stmt->bindParam(':id', $this->args['id'], 1);
        $stmt->bindParam(':name', $parsBody['name'], 2);
        $stmt->bindParam(':count', $parsBody['count'], 1);
        $stmt->bindParam(':code', $parsBody['code'], 2);
        $stmt->bindParam(':buy_price', $parsBody['buy_price'], 1);
        $stmt->bindParam(':sell_price', $parsBody['sell_price'], 1);
        $stmt->bindParam(':aed_price', $parsBody['aed_price'], 1);
        if ($stmt->execute())
            return $this->redirectTo('/');
        return $this->errorMessage('error');
    }
}
