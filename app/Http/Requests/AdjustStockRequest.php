<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdjustStockRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id'      => ['required','integer', Rule::exists('warehouses','id')],
            'inventory_item_id' => ['required','integer', Rule::exists('inventory_items','id')],
            'quantity'          => ['required','integer','min:1'],
        ];
    }
}
