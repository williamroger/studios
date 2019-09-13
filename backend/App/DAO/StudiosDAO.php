<?php

namespace App\DAO;

use App\Models\StudioModel;

class StudiosDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAllStudios(): array
  {
    $studios = $this->pdo
      ->query(' SELECT 
                  id,
                  name,
                  phone,
                  description,
                  cnpj,
                  telephone,
                  created_at,
                  updated_at,
                  has_parking,
                  is_24_hours,
                  city_id,
                  rate_cancellation,
                  days_cancellation
                FROM 
                  studios')
      ->fetchAll(\PDO::FETCH_ASSOC);

    return $studios;
  }

  public function insertStudio($studioName): string
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO studios
                  (name)
                VALUES (:name);');

    $statement->execute([
      'name' => $studioName
    ]);

    return $this->pdo->lastInsertId();
  }

  /*
  public function updateStudio(StudioModel $studio): void 
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO studios
                  (name, address, phone, description, cnpj, telephone, created_at, has_parking, is_24_hours, city_id)
                VALUES (
                  :name,
                  :address,
                  :phone,
                  :description,
                  :cnpj,
                  :telephone,
                  :created_at,
                  :has_parking,
                  :is_24_hours,
                  :city_id  
                );');

    $statement->execute([
      'name'        => $studio->getName(),
      'address'     => $studio->getAddress(),
      'phone'       => $studio->getPhone(),
      'decription'  => $studio->getDescription(),
      'cnpj'        => $studio->getCnpj(),
      'telephone'   => $studio->getTelephone(),
      'created_at'  => $studio->getCreated_at(),
      'has_parking' => $studio->getHasParking(),
      'is_24_hours' => $studio->getIs24Hours(),
      'city_id'     => $studio->getCityId() 
    ]);
  }
  */
}