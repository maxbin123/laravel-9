<?php

namespace App\Jobs;

use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use App\Utilities\Dto\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public Email $email
    ) {}

    public function handle(ElasticsearchHelperInterface $elastic, RedisHelperInterface $redis): void
    {
        $result = Mail::raw($this->email->body, function (Message $message) {
            $message->to($this->email->email)->subject($this->email->subject)->from('test@address.com');
        });

        if ($result) {
            $esId = $elastic->storeEmail($this->email);

            $redis->storeRecentMessage($esId, $this->email);
        }
    }
}
