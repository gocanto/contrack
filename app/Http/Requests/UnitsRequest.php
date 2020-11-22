<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Block;
use App\Models\Condominium;
use App\Models\Unit;
use App\Repository\CondominiumRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use RuntimeException;

class UnitsRequest extends FormRequest
{
    private CondominiumRepository $condos;
    public ?Condominium $condominium = null;
    public ?Block $block = null;
    public ?Unit $unit = null;

    public function authorize(CondominiumRepository $condominiums): bool
    {
        $this->condos = $condominiums;

        return true;
    }

    public function rules(): array
    {
        return [
            'condominium_uuid' => ['required'],
            'block_uuid' => ['required'],
            'number' => ['required'],
        ];
    }

    public function getData(): array
    {
        return [
            'condominium_id' => $this->condominium->id,
            'number' => $this->input('number'),
            'block_id' => $this->block->id,
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            try {
                $this->assertValidCondominium();
                $this->assertValidBlock();
                $this->assertValidNumber();
            } catch (RuntimeException $exception) {
                $validator->errors()->add('error', $exception->getMessage());
            }
        });
    }

    private function assertValidCondominium(): void
    {
        $condominium = $this->condos->findByUuid($this->input('condominium_uuid'));

        if ($condominium === null) {
            throw new RuntimeException('The given condominium is invalid.');
        }

        $this->condominium = $condominium;
    }

    private function assertValidBlock(): void
    {
        $block = $this->condos->findBlockBy($this->condominium, $this->input('block_uuid'));

        if ($block === null) {
            throw new RuntimeException('The given block is invalid.');
        }

        $this->block = $block;
    }

    private function assertValidNumber(): void
    {
        if ($this->isCreating()) {
            $this->doCreating();

            return;
        }

        $unit = $this->condos->findUnitBy($this->condominium, $this->block, $this->route('uuid'));

        if ($unit === null) {
            throw new RuntimeException('The given unit is invalid.');
        }

        if ($unit->number !== $this->getNumber() && $this->block->hasUnitNumber($this->getNumber())) {
            throw new RuntimeException('The given unit number is invalid.');
        }

        $this->unit = $unit;
    }

    private function isCreating(): bool
    {
        return $this->route('uuid') === null;
    }

    private function doCreating(): void
    {
        if ($this->block->hasUnitNumber($this->input('number'))) {
            throw new RuntimeException('The given unit number already exists.');
        }
    }

    private function getNumber(): string
    {
        return $this->input('number');
    }
}
