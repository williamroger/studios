<?php

use App\Controllers\StudioController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());
// ============================================================
$app->get('/', StudioController::class . ':getStudios');
// ============================================================
$app->run();