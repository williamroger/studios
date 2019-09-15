<?php

use App\Controllers\StudioController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());
// ============================================================
$app->get('/studio/getallstudios', StudioController::class . ':getAllStudios');
$app->post('/studio/insertstudio', StudioController::class . ':insertStudio');
$app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
$app->delete('/studio/deletestudio', StudioController::class . ':deleteStudio');
// ============================================================

$app->get('/customer/getallcustomer', StudioController::class . ':getAllCustomer');
$app->post('/customer/insertcustomer', StudioController::class . ':insertCustomer');
$app->put('/customer/updatecustomer', StudioController::class . ':updateCustomer');
$app->delete('/customer/deletecustomer', StudioController::class . ':deleteCustomer');

$app->run();