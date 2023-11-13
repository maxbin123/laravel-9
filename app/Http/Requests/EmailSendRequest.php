<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\InputBag;

class EmailSendRequest extends FormRequest
{
    public function authorize(): bool {
        $user = User::findOrFail($this->route('user'));

        if ($user->token === $this->query('api_token')) {
            $this->query = new InputBag();

            return true;
        }

        return false;
    }

    public function rules(): array
    {
        return [
            '*.email' => ['email', 'required'],
            '*.subject' => ['string:500', 'required'],
            '*.body' => ['string', 'required'],
        ];
    }
}
