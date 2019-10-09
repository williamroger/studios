<?php

use App\Controllers\AuthController;
use App\Controllers\StudioController;
use App\Controllers\CustomerController;
use App\Controllers\UtilController;
use App\Controllers\ScheduleController;

use function src\slimConfiguration;
use Slim\Http\UploadedFile;

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
  $app->post('/studio/insertperiod', StudioController::class . ':insertPeriod');
  $app->get('/studio/getallrooms', StudioController::class . ':getAllRooms');
  $app->get('/studio/getroombyid/{id}', StudioController::class . ':getRoomById');
  $app->get('/studio/getperiodbyid/{id}', StudioController::class . ':getPeriodById');
  $app->get('/studio/getroomsbystudioid/{id}', StudioController::class . ':getRoomsByStudioId');
  $app->get('/studio/getperiodsbyroomid/{id}', StudioController::class . ':getPeriodsByRoomId');
  $app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
  $app->put('/studio/updateroom', StudioController::class . ':updateRoom');
  $app->put('/studio/updateperiod', StudioController::class . ':updatePeriod');
  $app->delete('/studio/deletestudio/{id}', StudioController::class . ':deleteStudio');
  $app->delete('/studio/deleteroom/{id}', StudioController::class . ':deleteRoom');
  $app->delete('/studio/deleteperiod/{id}', StudioController::class . ':deletePeriod');
  $app->post('/studio/upload', StudioController::class . ':upload');

  // CUSTOMER ============================================================
  $app->get('/customer/getallcustomers', CustomerController::class . ':getAllCustomers');
  $app->get('/customer/getcustomerbyid/{id}', CustomerController::class . ':getCustomerById');
  $app->get('/customer/getstudiosbycityidcustomer/{id}', StudioController::class . ':getStudiosByCityIdCustomer');
  $app->post('/customer/insertcustomer', CustomerController::class . ':insertCustomer');
  $app->put('/customer/updatecustomer', CustomerController::class . ':updateCustomer');
  $app->delete('/customer/deletecustomer/{id}', CustomerController::class . ':deleteCustomer');

  // SCHEDULES ============================================================
  $app->post('/newschedule', ScheduleController::class . ':newSchedule');
  $app->get('/getschedulesbystudioid/{id}', ScheduleController::class . ':getSchedulesByStudioId');
  $app->get('/getschedulesbycustomerid/{id}', ScheduleController::class . ':getSchedulesByCustomerId');
  $app->get('/getschedulesbystudioidanddate/{id}/{date}', ScheduleController::class . ':getSchedulesByStudioIdAndDate');
  $app->get('/getperiodsfreebyroomidanddate/{id}/{day}/{date}', ScheduleController::class . ':getPeriodsFreeByRoomIdAndDate');

})->add(function ($req, $res, $next) {
  $response = $next($req, $res);
  return $response
    ->withHeader('Access-Control-Allow-Origin', '*')
    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();