<?php

namespace App\DAO;

class StudiosDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function testEstados()
  {
    $estados = $this->pdo
      ->query('SELECT * FROM states')
      ->fetchAll(\PDO::FETCH_ASSOC);

    echo "<pre>";
    foreach($estados as $est) {
      var_dump($est);
    }
    die;
  }
}