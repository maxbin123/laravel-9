<?php

namespace App\Utilities\Helpers;

use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\Dto\Email;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class RedisHelper implements RedisHelperInterface {
    /**
     * Store the id of a message along with a message subject in Redis.
     *
     * @param mixed $id
     * @param Email $email
     * @return void
     */
    public function storeRecentMessage(mixed $id, Email $email): void {

        Redis::set($id, $email->subject);
    }
}
