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
      'created_at' => $user->getCreatedAt(),
      'studio_id' => $user->getStudioId(),
      'is_studio' => $user->getIsStudio()
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
      'updated_at' => $user->getUpdatedAt(),
      'studio_id' => $user->getStudioId()
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
      'created_at' => $user->getCreatedAt(),
      'customer_id' => $user->getCustomerId(),
      'is_customer' => $user->getIsCustomer()
    ]);
  }

  public function updateUserCustomer(UserModel $user): void
  {
    $statement = $this->pdo
      ->prepare('UPDATE users SET
                    email = :email,
                    updated_at = :updated_at
                 WHERE
                    customer_id = :customer_id;');
    
    $statement->execute([
      'email' => $user->getEmail(),
      'updated_at' => $user->getUpdatedAt(),
      'customer_id' => $user->getCustomerId()
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

  public function emailExists(string $email): int
  {
    $statement = $this->pdo
      ->prepare('SELECT 
                    id
                 FROM
                    users
                 WHERE email = :email');
    $statement->execute([
      'email' => $email
    ]);

    return $statement->rowCount(\PDO::FETCH_ASSOC);
  }

  public function getUserByEmail(string $email): ?UserModel {
    $statement = $this->pdo
      ->prepare('SELECT
                    id,
                    email,
                    password,
                    studio_id,
                    customer_id,
                    is_studio,
                    is_customer
                 FROM 
                    users
                 WHERE email = :email');
    
    $statement->bindParam('email', $email);
    $statement->execute();

    $users = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (count($users) === 0) 
      return null;

    $user = new UserModel();
    $user->setId($users[0]['id'])
      ->setEmail($users[0]['email'])
      ->setPassword($users[0]['password'])
      ->setStudioId(intval($users[0]['studio_id']))
      ->setCustomerId(intval($users[0]['customer_id']))
      ->setIsStudio(intval($users[0]['is_studio']))
      ->setIsCustomer(intval($users[0]['is_customer']));

    return $user;
  }
}