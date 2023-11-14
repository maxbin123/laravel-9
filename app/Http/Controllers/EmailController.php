<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailSendRequest;
use App\Jobs\SendEmailJob;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Dto\Email;
use Illuminate\Support\Collection;

class EmailController extends Controller
{
    public function send(EmailSendRequest $request)
    {

        foreach ($request->validated() as $email) {
            SendEmailJob::dispatch(new Email(...$email));
        }

        return response()->json(['queued' => true]);
    }

    public function list(ElasticsearchHelperInterface $elastic): Collection
    {

        return $elastic->getSentEmails();
    }
}
