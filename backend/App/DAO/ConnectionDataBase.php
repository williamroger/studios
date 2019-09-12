<?php

namespace App\DAO;

abstract class ConnectionDataBase
{
  /**
   * @var \PDO
   */
  protected $pdo;

  public function __construct()
  {
    $host = getenv('STUDIOS_HOST');
    $port = getenv('STUDIOS_PORT');
    $username = getenv('STUDIOS_USER');
    $password = getenv('STUDIOS_PASSWORD');
    $dbname = getenv('STUDIOS_DBNAME');

    $dsn = "mysql:host={$host};dbname={$dbname};port={$port};charset=utf8";

    $this->pdo = new \PDO($dsn, $username, $password);
    
    $this->pdo->setAttribute(
      \PDO::ATTR_ERRMODE,
      \PDO::ERRMODE_EXCEPTION
    );
  }
}