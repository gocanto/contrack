<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Block;
use App\Models\Unit;
use App\Repository\BlockRepository;
use App\Repository\UnitRepository;
use App\Repository\VisitRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisitsRequest extends FormRequest
{
    private UnitRepository $units;
    private BlockRepository $blocks;
    private VisitRepository $visits;

    public function authorize(UnitRepository $units, BlockRepository $blocks, VisitRepository $visits): bool
    {
        $this->units = $units;
        $this->blocks = $blocks;
        $this->visits = $visits;

        return true;
    }

    public function rules(): array
    {
        return [
            'visitor_first_name' => ['required'],
            'visitor_last_name' => ['required'],
            'phone_number' => ['required'],
            'nric_last_r' => ['required', 'min:3'],
            'block_number' => ['required', Rule::exists('blocks', 'number'), 'bail'],
            'unit_number' => ['required', Rule::exists('units', 'number'), 'bail'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $unit = $this->getUnit();
        $block = $this->getBlock();

        $validator->after(function (Validator $validator) use ($block, $unit): void {
            if (!$unit->isRented()) {
                $validator->errors()->add('unit', 'The given unit is not rented.');

                return;
            }

            if ($block->doestNotHaveUnit($unit)) {
                $validator->errors()->add(
                    'unit',
                    'The given unit: ' . $unit->number . ' does not belong to the given block: ' . $block->number . '.'
                );

                return;
            }

            if (!$this->route('uuid') && $this->visits->hasVisitor($unit, $this->input('nric_last_r'))) { //editing
                $validator->errors()->add('exists', 'The given nric is already visiting the given unit.');

                return;
            }
        });
    }

    public function getBlock(): Block
    {
        return $this->blocks->findByNumber($this->input('block_number'));
    }

    public function getUnit(): Unit
    {
        return $this->units->findByNumber($this->input('unit_number'));
    }

    public function getData(): array
    {
        return [
            'visitor_first_name' => $this->input('visitor_first_name'),
            'visitor_last_name' => $this->input('visitor_last_name'),
            'phone_number' => $this->input('phone_number'),
            'nric_last_r' => $this->input('nric_last_r'),
        ];
    }
}
