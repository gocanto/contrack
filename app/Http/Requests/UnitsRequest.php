<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitsRequest extends FormRequest
{
    public function rules(): array
    {
        $number = Rule::unique('units');

        if ($this->route('uuid') !== null) { //editing
            $number->ignore($this->input('uuid'), 'uuid');
        }

        return [
            'condominium_uuid' => ['required', Rule::exists('condominiums', 'uuid'), 'bail'],
            'block_uuid' => ['required', Rule::exists('blocks', 'uuid'), 'bail'],
            'number' => ['required', $number, 'bail'],
        ];
    }

    public function getData(): array
    {
        return [
            'condominium_uuid' => $this->input('condominium_uuid'),
            'block_uuid' => $this->input('block_uuid'),
            'number' => $this->input('number'),
        ];
    }
}
