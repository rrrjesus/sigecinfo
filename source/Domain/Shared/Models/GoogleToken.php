<?php

namespace Source\Domain\Shared\Models;

use Source\Core\Model;

class GoogleToken extends Model
{
    public function __construct()
    {
        parent::__construct("google_auth_tokens", ["id"], ["user_id", "access_token", "refresh_token", "expires_in"]);
    }

    public function findByUserId(int $userId): ?GoogleToken
    {
        return $this->find("user_id = :user_id", "user_id={$userId}")->fetch();
    }
}
