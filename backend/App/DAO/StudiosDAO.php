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
    $studios = $this->pdo
      ->query('SELECT * FROM studios')
      ->fetchAll(\PDO::FETCH_ASSOC);

    echo "<pre>";
    foreach($studios as $studio) {
      var_dump($studio);
    }
    die;
  }
}