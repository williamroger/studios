<?php

use App\Controllers\StudiosController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());
// ============================================================
$app->get('/', StudiosController::class . ':getStudios');
// ============================================================
$app->run();