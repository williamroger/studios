<?php

use App\Controllers\StudioController;

use function src\slimConfiguration;

$app = new \Slim\App(slimConfiguration());
// ============================================================
$app->get('/studio/getallstudios', StudioController::class . ':getAllStudios');
$app->post('/studio/insertstudio', StudioController::class . ':insertStudio');
$app->put('/studio/updatestudio', StudioController::class . ':updateStudio');
$app->delete('/studio', StudioController::class . ':deleteStudio');
// ============================================================
$app->run();