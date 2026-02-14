<?php

declare(strict_types=1);

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseInventorySearchRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'search_word' => trim((string)($this->search_word ?? null))
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'warehouse_id' => ['nullable','integer', Rule::exists('warehouses','id')],
            'item_id'      => ['nullable','integer', Rule::exists('inventory_items','id')],
            'sku'          => ['nullable','string','max:100'],
            'search_word'  => ['nullable','string','max:255'],
            'min_qty'      => ['nullable','integer','min:0'],
            'max_qty'      => ['nullable','integer','min:0'],
            'low_stock'    => ['nullable','boolean'],
            'limit'        => ['nullable','integer','min:1','max:200'],
        ];
    }
}
