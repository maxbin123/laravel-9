<?php

namespace Tests\Feature;

use App\Models\User;
use Elasticsearch;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class SendEmailTest extends TestCase
{
    public function test_email_should_be_sent_on_request()
    {
        $this->seed();
        $user = User::first();

        Mail::shouldReceive('raw')->once()->andReturn(true);
        Elasticsearch::shouldReceive('index')->once()->andReturn(['_id' => '12345678']);
        Redis::shouldReceive('set')->once()->andReturn(true);

        $this->postJson("api/{$user->id}/send?api_token=" . $user->token,
            [
                [
                    'email' => 'test@email.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        )
            ->assertStatus(200)
            ->assertJson(['queued' => true]);
    }

    public function test_emails_array_should_be_sent_on_request()
    {
        $this->seed();
        $user = User::first();

        Mail::shouldReceive('raw')->twice()->andReturn(true);
        Elasticsearch::shouldReceive('index')->twice()->andReturn(['_id' => '12345678']);
        Redis::shouldReceive('set')->twice()->andReturn(true);

        $this->postJson("api/{$user->id}/send?api_token=" . $user->token,
            [
                [
                    'email' => 'test@email.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ],
                [
                    'email' => 'test2@email.com',
                    'subject' => 'Test Subject2',
                    'body' => 'Test Body2'
                ]
            ]
        )
            ->assertStatus(200)
            ->assertJson(['queued' => true]);
    }

    public function test_emails_should_not_be_sent_on_wrong_api_key()
    {
        $this->seed();
        $user = User::first();

        $this->postJson("api/{$user->id}/send?api_token=wrong-key",
            [
                [
                    'email' => 'test@email.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        )
            ->assertStatus(403);
    }

    public function test_emails_should_not_be_sent_on_wrong_email()
    {
        $this->seed();
        $user = User::first();

        $this->postJson("api/{$user->id}/send?api_token=" . $user->token,
            [
                [
                    'email' => 'testemail.com',
                    'subject' => 'Test Subject',
                    'body' => 'Test Body'
                ]
            ]
        )
        ->assertJsonValidationErrors('0.email');
    }
}
