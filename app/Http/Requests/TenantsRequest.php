<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantsRequest extends FormRequest
{
    public function rules(): array
    {
        $phoneNumber = Rule::unique('tenants');

        if ($this->route('uuid') !== null) { //editing
            $phoneNumber->ignore($this->route('uuid'), 'uuid');
        }

        return [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone_number' => ['required', $phoneNumber, 'bail'],
        ];
    }

    public function getData(): array
    {
        return [
            'first_name' => $this->input('first_name'),
            'last_name' => $this->input('last_name'),
            'phone_number' => $this->input('phone_number'),
        ];
    }
}
