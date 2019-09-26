<?php

namespace App\DAO;

use App\Models\UserModel;
use App\Models\TokenModel;
class TokensDAO extends ConnectionDataBase 
{
  public function __construct()
  {
    parent::__construct();
  }

  public function createToken(TokenModel $token): void
  {
    $statement = $this->pdo
      ->prepare('INSERT INTO tokens 
                 ( token,
                   refresh_token,
                   expired_at,
                   user_id
                 )
                 VALUES 
                 ( :token,
                   :refresh_token,
                   :expired_at,
                   :user_id
                 );
              ');
    $statement->execute([
      'token'         => $token->getToken(),
      'refresh_token' => $token->getRefreshToken(),
      'expired_at'    => $token->getExpiredAt(),
      'user_id'       => $token->getUserId()
    ]);
  }
}