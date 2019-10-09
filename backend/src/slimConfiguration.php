<?php

namespace src;

function slimConfiguration(): \Slim\Container 
{
  $configuration = [
    'settings' => [
      'displayErrorDetails' => getenv('DISPLAY_ERRORS_DETAILS'),
      'upload_directory' => __DIR__ . './../public/uploads'
    ],
  ];
  return new \Slim\Container($configuration);
}