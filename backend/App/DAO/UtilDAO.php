<?php

namespace App\DAO;

class UtilDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAllStates(): array 
  {
    $states = $this->pdo
      ->query('SELECT 
                  id,
                  initials,
                  name
               FROM states;')
      ->fetchAll(\PDO::FETCH_ASSOC);
    
    return $states;
  }

  public function getAllCities(): array 
  {
    $cities = $this->pdo
      ->query('SELECT 
                  id,
                  state_id,
                  name
               FROM
                  cities;')
      ->fetchAll(\PDO::FETCH_ASSOC);

    return $cities;
  }

  public function getCityByStateId(int $idState): array 
  {
    $statement = $this->pdo
      ->prepare('SELECT
	                id,
                  state_id,
                  name
               FROM cities
               WHERE state_id = :id;');
    $statement->execute([
      'id' => $idState
    ]);

    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }
}