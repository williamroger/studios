<?php

use App\Controllers\StudioController;
use App\Controllers\CustomerController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());

$app->group('', function() use ($app) {
  // STUDIO =============================================================
  $app->get('/studio/getallstudios', StudioController::class . ':getAllStudios');
  $app->post('/studio/insertstudio', StudioController::class . ':insertStudio');
  $app->post('/studio/insertroom', StudioController::class . ':insertRoom');
  $app->get('/studio/getallrooms', StudioController::class . ':getAllRooms');
  $app->get('/studio/getroomsbystudioid', StudioController::class . ':getRoomsByStudioId');
  $app->put('/studio/updateroom', StudioController::class . ':updateRoom');
  $app->delete('/studio/deleteroom', StudioController::class . ':deleteRoom');
  $app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
  $app->delete('/studio/deletestudio', StudioController::class . ':deleteStudio');

  // CUSTOMER ============================================================
  $app->get('/customer/getallcustomers', CustomerController::class . ':getAllCustomers');
  $app->get('/customer/getstudiosbycityidcustomer', StudioController::class . ':getStudiosByCityIdCustomer');
  $app->post('/customer/insertcustomer', CustomerController::class . ':insertCustomer');
  $app->put('/customer/updatecustomer', CustomerController::class . ':updateCustomer');
  $app->delete('/customer/deletecustomer', CustomerController::class . ':deleteCustomer');
})->add(new Tuupola\Middleware\CorsMiddleware([
  "origin" => ["*"],
  "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
  "headers.allow" => [],
  "headers.expose" => [],
  "credentials" => false,
  "cache" => 0,
]));

$app->run();