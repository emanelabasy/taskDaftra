<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StockTransferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_warehouse_id' => ['required','integer', Rule::exists('warehouses','id')],
            'to_warehouse_id'   => ['required','integer', Rule::exists('warehouses','id'), 'different:from_warehouse_id'],
            'inventory_item_id' => ['required','integer', Rule::exists('inventory_items','id')],
            'quantity'          => ['required','integer','min:1'],
            'reference'         => ['nullable','string','max:255'],
        ];
    }
}
