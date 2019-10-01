<?php

namespace App\DAO;

use App\Models\RoomModel;
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
                  days_cancellation,
                  zip_code,
                  street,
                  complement,
                  district,
                  number,
                  image
                FROM 
                  studios')
      ->fetchAll(\PDO::FETCH_ASSOC);

    return $studios;
  }

  public function getStudioById(int $idStudio): ?array
  {
    $statement = $this->pdo
      ->prepare('SELECT 
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
                    days_cancellation,
                    zip_code,
                    street,
                    complement,
                    district,
                    number,
                    image
                 FROM
                    studios
                 WHERE id = :id');
    $statement->execute([
      'id' => $idStudio
    ]);

    $studios = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($studios) === 0)
      return null;
    
    return $studios[0];
  }

  public function studioExists(int $idStudio): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    name
                 FROM
                    studios
                 WHERE id = :id');
    $statement->execute([
      'id' => $idStudio
    ]);
  
    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function studioNameExists(string $nameStudio): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    name
                 FROM
                    studios
                 WHERE name = :name');
    $statement->execute([
      'name' => $nameStudio
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function studioCNPJExists(string $studioCNPJ, int $idStudio): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    cnpj
                 FROM
                    studios
                 WHERE cnpj = :cnpj AND id != :id');
    $statement->execute([
      'cnpj' => $studioCNPJ,
      'id' => $idStudio
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function getStudiosByCityIdCustomer(int $idCustomer): array
  {
    $statement = $this->pdo
      ->prepare("SELECT 
                studios.id,
                studios.name,
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
                studios.days_cancellation,
                studios.zip_code,
                studios.street,
                studios.complement,
                studios.district,
                studios.number,
                studios.image
               FROM studios
               INNER JOIN customers
               on studios.city_id = customers.city_id
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
                    phone = :phone,
                    description = :description,
                    cnpj = :cnpj,
                    telephone = :telephone,
                    updated_at = :updated_at,
                    has_parking = :has_parking,
                    is_24_hours = :is_24_hours,
                    city_id = :city_id,
                    rate_cancellation = :rate_cancellation,
                    days_cancellation = :days_cancellation,
                    zip_code = :zip_code,
                    street = :street,
                    complement = :complement,
                    district = :district,
                    number = :number,
                    image = :image
                 WHERE 
                    id = :id;');

    $statement->execute([
      'name'              => $studio->getName(),
      'phone'             => $studio->getPhone(),
      'description'       => $studio->getDescription(),
      'cnpj'              => $studio->getCnpj(),
      'telephone'         => $studio->getTelephone(),
      'updated_at'        => $studio->getUpdatedAt(),
      'has_parking'       => $studio->getHasParking(),
      'is_24_hours'       => $studio->getIs24Hours(),
      'city_id'           => $studio->getCityId(),
      'rate_cancellation' => $studio->getRateCancellation(),
      'days_cancellation' => $studio->getDaysCancellation(),
      'zip_code'          => $studio->getZipCode(),
      'street'            => $studio->getStreet(),
      'complement'        => $studio->getComplement(),
      'district'          => $studio->getDistrict(),
      'number'            => $studio->getNumber(),
      'image'             => $studio->getImage(),
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

  public function insertRoom(RoomModel $room): void
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO rooms 
                  (description, 
                   studio_id, 
                   name, 
                   maximum_capacity, 
                   color, 
                   created_at,
                   images)
                 VALUES
                    (:description, 
                     :studio_id, 
                     :name, 
                     :maximum_capacity, 
                     :color, 
                     :created_at,
                     :images)');

    $statement->execute([
      'description'      => $room->getDescription(), 
      'studio_id'        => $room->getStudioId(), 
      'name'             => $room->getName(), 
      'maximum_capacity' => $room->getMaximumCapacity(), 
      'color'            => $room->getColor(), 
      'created_at'       => $room->getCreatedAt(),
      'images'           => $room->getImages()
    ]);
  }

  public function getAllRooms(): array 
  {
    $rooms = $this->pdo
      ->query('SELECT 
                id,
                name,
                studio_id,
                description,
                maximum_capacity,
                color,
                created_at,
                updated_at
               FROM 
                rooms;')
      ->fetchAll(\PDO::FETCH_ASSOC);

    return $rooms;
  }

  public function updateRoom(RoomModel $room): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE rooms SET
                    name = :name,
                    description = :description,
                    maximum_capacity = :maximum_capacity,
                    color = :color,
                    updated_at = :updated_at,
                    images = :images
                 WHERE 
                    id = :id;');

    $statement->execute([
      'name'             => $room->getName(),
      'description'      => $room->getDescription(),
      'maximum_capacity' => $room->getMaximumCapacity(),
      'color'            => $room->getColor(),
      'updated_at'       => $room->getUpdatedAt(),
      'images'           => $room->getImages(),
      'id'               => $room->getId()
    ]);
  }

  public function deleteRoom(int $idRoom): void
  {
    $statement = $this->pdo
      ->prepare('DELETE FROM rooms WHERE id = :id');

    $statement->execute([
      'id' => $idRoom
    ]);
  }

  public function getRoomsByStudioId(int $idStudio) 
  {
    $statement = $this->pdo
      ->prepare("SELECT 
                   rooms.id,
                   rooms.studio_id,
                   rooms.name,
                   rooms.description,
                   rooms.maximum_capacity,
                   rooms.color,
                   rooms.created_at,
                   rooms.updated_at,
                   rooms.images
                 FROM rooms
                 INNER JOIN studios
                 ON rooms.studio_id = studios.id
                 WHERE studios.id = :id");
    
    $statement->execute([
      'id' => $idStudio
    ]);

    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function getRoomById(int $idRoom)
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    description,
                    studio_id,
                    name,
                    maximum_capacity,
                    color,
                    created_at,
                    updated_at,
                    images
                 FROM
                    rooms
                 WHERE id = :id');
    $statement->execute([
      'id' => $idRoom
    ]);

    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }

  public function roomExists(int $idRoom): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    name
                 FROM
                    rooms
                 WHERE id = :id');
    $statement->execute([
      'id' => $idRoom
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function getPeriodsByRoomId(int $idRoom)
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    amount,
                    room_id,
                    day,
                    price_rate,
                    begin_period,
                    end_period,
                    created_at,
                    updated_at
                FROM time_periods
                WHERE room_id = :id;');
    $statement->execute([
      'id' => $idRoom
    ]);

    return $statement->fetchAll(\PDO::FETCH_ASSOC);
  }
}