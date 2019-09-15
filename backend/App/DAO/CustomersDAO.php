<?php

namespace App\DAO;

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
}