<?php

use App\Controllers\StudioController;
use App\Controllers\CustomerController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());

// STUDIO =============================================================
$app->get('/studio/getallstudios', StudioController::class . ':getAllStudios');
$app->post('/studio/insertstudio', StudioController::class . ':insertStudio');
$app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
$app->delete('/studio/deletestudio', StudioController::class . ':deleteStudio');

// CUSTOMER ============================================================
$app->get('/customer/getallcustomers', CustomerController::class . ':getAllCustomers');
$app->get('/customer/getstudiosbycityidcustomer', StudioController::class . ':getStudiosByCityIdCustomer');
$app->post('/customer/insertcustomer', CustomerController::class . ':insertCustomer');
$app->put('/customer/updatecustomer', CustomerController::class . ':updateCustomer');
$app->delete('/customer/deletecustomer', CustomerController::class . ':deleteCustomer');

$app->run();