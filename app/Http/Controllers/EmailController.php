<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmailSendRequest;
use App\Jobs\SendEmailJob;
use App\Utilities\Dto\Email;

class EmailController extends Controller
{
    // TODO: finish implementing send method
    public function send(EmailSendRequest $request)
    {

        foreach ($request->validated() as $email) {
            SendEmailJob::dispatch(new Email(...$email));
        }

        return 'OK';
    }

    //  TODO - BONUS: implement list method
    public function list()
    {

    }
}
