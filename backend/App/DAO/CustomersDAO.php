<?php

namespace App\DAO;

use App\Models\CustomerModel;

class CustomersDAO extends ConnectionDataBase
{
  public function __construct()
  {
    parent::__construct();
  }

  public function getAllCustomers(): array 
  {
    $customer = $this->pdo
      ->query('SELECT 
                  id,
                  firstname,
                  lastname,
                  phone,
                  created_at,
                  updated_at,
                  cpf,
                  city_id,
                  image
               FROM customers')
      ->fetchAll(\PDO::FETCH_ASSOC);
      
    return $customer;
  }

  public function getCustomerById(int $customerId): ?array {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    firstname,
                    lastname,
                    phone,
                    cpf,
                    city_id,
                    image
                 FROM
                    customers
                 WHERE id = :id;');

    $statement->bindParam('id', $customerId);
    $statement->execute();

    $customers = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($customers) === 0)
      return null;

    return $customers[0];
  }

  public function getEmailByCustomerId($customerId) {
    $statement = $this->pdo
      ->prepare('SELECT users.email FROM users
                WHERE users.customer_id = :id;');

    $statement->bindParam('id', $customerId);
    $statement->execute();

    $email = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
    return $email[0];
  }

  public function insertCustomer($firstName, $lastName, $createdAt): string
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO customers
                  (firstname, lastname, created_at)
                VALUES (:firstname, :lastname, :created_at);');

    $statement->execute([
      'firstname'  => $firstName,
      'lastname'   => $lastName,
      'created_at' => $createdAt
    ]);

    return $this->pdo->lastInsertId();
  }

  public function updateCustomer(CustomerModel $customer): void 
  {
    $statement = $this->pdo
      ->prepare('UPDATE customers SET 
                    firstname = :firstname,
                    lastname = :lastname,
                    phone = :phone,
                    updated_at = :updated_at,
                    cpf = :cpf,
                    city_id = :city_id,
                    image = :image
                 WHERE 
                    id = :id;');

    $statement->execute([
      'firstname'  => $customer->getFirstName(),
      'lastname'   => $customer->getLastName(),
      'phone'      => $customer->getPhone(),
      'updated_at' => $customer->getUpdatedAt(),
      'cpf'        => $customer->getCpf(),
      'city_id'    => $customer->getCityId(),
      'image'      => $customer->getImage(),
      'id'         => $customer->getId() 
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

  public function customerExists(int $idCustomer): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id,
                    firstname,
                    lastname
                 FROM
                    customers
                 WHERE id = :id');
    $statement->execute([
      'id' => $idCustomer
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }
}

