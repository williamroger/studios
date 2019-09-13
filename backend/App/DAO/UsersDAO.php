<?php

namespace App\DAO;

use App\Models\UserModel;

class UsersDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function insertUser(UserModel $user): void {
    $statement = $this->pdo
      ->prepare('INSERT INTO users 
                  (email, password, created_at, customer_id, studio_id, is_studio, is_customer)
                 VALUES (
                   :email, 
                   :password, 
                   :created_at,
                   :customer_id, 
                   :studio_id, 
                   :is_studio,
                   :is_customer
                 );');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'password' => $user->getPassword(),
      'created_at' => $user->getCreated_at(),
      'customer_id' => $user->getCustomer_id() ?? '',
      'studio_id' => $user->getStudio_id() ?? '',
      'is_studio' => $user->getIs_studio(),
      'is_customer' => $user->getIs_customer()
    ]);

  }
}