<?php

use App\Controller\HomeAction;
use App\Controller\Product\ProductCreate;
use App\Controller\Product\ProductDelete;
use App\Controller\Product\ProductGetUpdate;
use App\Controller\Product\ProductUpdate;
use Slim\App;

return function (App $app) {
    $app->get('/', HomeAction::class);
//    $app->post('/users', UserCreateAction::class);
    $app->post('/create', ProductCreate::class);
    $app->get('/update/{id:[0-9]+}', ProductGetUpdate::class);
    $app->post('/update/{id:[0-9]+}', ProductUpdate::class);
    $app->get('/delete/{id:[0-9]+}', ProductDelete::class);

};
