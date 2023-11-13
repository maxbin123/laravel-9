<?php

namespace App\Utilities\Contracts;

use App\Utilities\Dto\Email;
use Illuminate\Database\Eloquent\Model;

interface RedisHelperInterface {
    /**
     * Store the id of a message along with a message subject in Redis.
     *
     * @param mixed $id
     * @param Email $email
     * @return void
     */
    public function storeRecentMessage(mixed $id, Email $email): void;
}
