<?php

use App\Controllers\StudioController;
use App\Controllers\CustomerController;
use App\Controllers\UserController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());

$app->group('', function() use ($app) {

  // USER ===============================================================
  $app->get('/user/getallstates', UserController::class . 'getAllStates');
  $app->get('/user/getallcities', UserController::class . 'getAllCities');
  $app->get('/user/getcitybystateid', UserController::class . 'getCityByStateId');

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
})->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();