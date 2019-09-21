<?php

namespace App\DAO;

use App\Models\UserModel;

class UsersDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function insertUserStudio(UserModel $user): void 
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO users 
                  (email, password, created_at, studio_id, is_studio)
                 VALUES (
                   :email, 
                   :password, 
                   :created_at,
                   :studio_id, 
                   :is_studio
                 );');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'password' => $user->getPassword(),
      'created_at' => $user->getCreated_at(),
      'studio_id' => $user->getStudio_id(),
      'is_studio' => $user->getIs_studio()
    ]);
  }

  public function updateUserStudio(UserModel $user): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE users SET
                    email = :email,
                    updated_at = :updated_at
                 WHERE
                    studio_id = :studio_id;');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'updated_at' => $user->getUpdated_at(),
      'studio_id' => $user->getStudio_id()
    ]);
  }

  public function deleteUserStudio(int $idStudio): void 
  {
    $statement = $this->pdo
      ->prepare('DELETE FROM users WHERE studio_id = :studio_id');
    
    $statement->execute([
      'studio_id' => $idStudio
    ]);
  }

  public function insertUserCustomer(UserModel $user): void 
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO users 
                  (email, password, created_at, customer_id, is_customer)
                 VALUES (
                   :email, 
                   :password, 
                   :created_at,
                   :customer_id, 
                   :is_customer
                 );');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'password' => $user->getPassword(),
      'created_at' => $user->getCreated_at(),
      'customer_id' => $user->getCustomer_id(),
      'is_customer' => $user->getIs_customer()
    ]);
  }

  public function updateUserCustomer(UserModel $user): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE users SET
                    email = :email,
                    password = :password,
                    updated_at = :updated_at
                 WHERE
                    customer_id = :customer_id;');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'password' => $user->getPassword(),
      'updated_at' => $user->getUpdated_at(),
      'customer_id' => $user->getCustomer_id()
    ]);
  }

  public function deleteUserCustomer(int $idCustomer): void 
  {
    $statement = $this->pdo
      ->prepare('DELETE FROM users WHERE customer_id = :customer_id;');
    
    $statement->execute([
      'customer_id' => $idCustomer
    ]);
  }
}