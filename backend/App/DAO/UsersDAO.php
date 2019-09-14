<?php

namespace App\DAO;

use App\Models\UserModel;

class UsersDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function insertUserStudio(UserModel $user): void {
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
}