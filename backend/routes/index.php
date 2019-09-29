<?php

use App\Controllers\AuthController;
use App\Controllers\StudioController;
use App\Controllers\CustomerController;
use App\Controllers\UtilController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());

$app->group('', function() use ($app) {
  // Auth ===============================================================
  $app->post('/login', AuthController::class . ':login');

  // Util ===============================================================
  $app->get('/getallstates', UtilController::class . ':getAllStates');
  $app->get('/getallcities', UtilController::class . ':getAllCities');
  $app->get('/getcitiesbystateid/{id}', UtilController::class . ':getCitiesByStateId');

  // STUDIO =============================================================
  $app->get('/studio/getallstudios', StudioController::class . ':getAllStudios');
  $app->get('/studio/getstudiobyid/{id}', StudioController::class . ':getStudioById');
  $app->post('/studio/insertstudio', StudioController::class . ':insertStudio');
  $app->post('/studio/insertroom', StudioController::class . ':insertRoom');
  $app->get('/studio/getallrooms', StudioController::class . ':getAllRooms');
  $app->get('/studio/getroombyid/{id}', StudioController::class . ':getRoomById');
  $app->get('/studio/getroomsbystudioid/{id}', StudioController::class . ':getRoomsByStudioId');
  $app->put('/studio/updateroom', StudioController::class . ':updateRoom');
  $app->delete('/studio/deleteroom/{id}', StudioController::class . ':deleteRoom');
  $app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
  $app->delete('/studio/deletestudio/{id}', StudioController::class . ':deleteStudio');

  // CUSTOMER ============================================================
  $app->get('/customer/getallcustomers', CustomerController::class . ':getAllCustomers');
  $app->get('/customer/getcustomerbyid/{id}', CustomerController::class . ':getCustomerById');
  $app->get('/customer/getstudiosbycityidcustomer/{id}', StudioController::class . ':getStudiosByCityIdCustomer');
  $app->post('/customer/insertcustomer', CustomerController::class . ':insertCustomer');
  $app->put('/customer/updatecustomer', CustomerController::class . ':updateCustomer');
  $app->delete('/customer/deletecustomer/{id}', CustomerController::class . ':deleteCustomer');

})->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();