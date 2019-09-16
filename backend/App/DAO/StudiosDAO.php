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
                  address,
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

  public function getStudiosByCityIdCustomer(int $idCustomer): array
  {
    $statement = $this->pdo
      ->prepare("SELECT 
                studios.id,
                studios.name,
                studios.address,
                studios.phone,
                studios.description,
                studios.cnpj,
                studios.telephone,
                studios.created_at,
                studios.updated_at,
                studios.has_parking,
                studios.is_24_hours,
                studios.city_id,
                studios.rate_cancellation,
                studios.days_cancellation
               FROM studios
               INNER JOIN customers
               on studios.city_id = customers.cities_id
               WHERE customers.id = :id");

    $statement->execute([
      'id' => $idCustomer
    ]);

    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function insertStudio($studioName, $createdAt): string
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO studios
                  (name, created_at)
                VALUES (:name, :created_at);');

    $statement->execute([
      'name' => $studioName,
      'created_at' => $createdAt
    ]);

    return $this->pdo->lastInsertId();
  }

  public function updateStudio(StudioModel $studio): void 
  {
    $statement = $this->pdo
      ->prepare('UPDATE studios SET 
                    name = :name,
                    address = :address,
                    phone = :phone,
                    description = :description,
                    cnpj = :cnpj,
                    telephone = :telephone,
                    updated_at = :updated_at,
                    has_parking = :has_parking,
                    is_24_hours = :is_24_hours,
                    city_id = :city_id,
                    rate_cancellation = :rate_cancellation,
                    days_cancellation = :days_cancellation
                 WHERE 
                    id = :id;');

    $statement->execute([
      'name'              => $studio->getName(),
      'address'           => $studio->getAddress(),
      'phone'             => $studio->getPhone(),
      'description'        => $studio->getDescription(),
      'cnpj'              => $studio->getCnpj(),
      'telephone'         => $studio->getTelephone(),
      'updated_at'        => $studio->getUpdated_at(),
      'has_parking'       => $studio->getHasParking(),
      'is_24_hours'       => $studio->getIs24Hours(),
      'city_id'           => $studio->getCityId(),
      'rate_cancellation' => $studio->getRateCancellation(),
      'days_cancellation' => $studio->getDaysCancellation(),
      'id'                => $studio->getId() 
    ]);
  }

  public function deleteStudio(int $idStudio): void 
  {
    $statement = $this->pdo
      ->prepare('DELETE FROM studios WHERE id = :id');

    $statement->execute([
      'id' => $idStudio
    ]);
  }
}