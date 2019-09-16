<?php

namespace App\DAO;

use App\Models\CustomerModel;

class CustomersDAO extends ConnectionDataBase
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAllCustomers(): array{
    $customer = $this->pdo
      ->query('SELECT 
                  id,
                  name,
                  phone,
                  created_at,
                  updated_at,
                  cpf,
                  cities_id
               FROM customers')
      ->fetchAll(\PDO::FETCH_ASSOC);
      
    return $customer;
  }

  public function insertCustomer($customerName, $createdAt): string
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO customers
                  (name, created_at)
                VALUES (:name, :created_at);');

    $statement->execute([
      'name' => $customerName,
      'created_at' => $createdAt
    ]);

    return $this->pdo->lastInsertId();
  }

  public function updateCustomer(CustomerModel $customer): void 
  {
    $statement = $this->pdo
      ->prepare('UPDATE customers SET 
                    name = :name,
                    phone = :phone,
                    updated_at = :updated_at,
                    cpf = :cpf,
                    cities_id = :cities_id
                 WHERE 
                    id = :id;');

    $statement->execute([
      'name'              => $customer->getName(),
      'phone'             => $customer->getPhone(),
      'updated_at'        => $customer->getUpdated_at(),
      'cpf'               => $customer->getCpf(),
      'cities_id'         => $customer->getCities_id(),
      'id'                => $customer->getId() 
    ]);
  }

  public function deleteCustomer(int $idCustomer): void 
  {
    $statement = $this->pdo
      ->prepare('DELETE FROM customers WHERE id = :id');

    $statement->execute([
      'id' => $idCustomer
    ]);
  }

}

