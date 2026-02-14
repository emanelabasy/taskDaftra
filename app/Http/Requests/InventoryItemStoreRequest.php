<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryItemStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $itemId = $this->route('inventory_item')?->id;

        return [
            'name'        => ['required','string','max:255'],
            'sku'         => ['required','string','max:100', Rule::unique('inventory_items','sku')->ignore($itemId)],
            'description' => ['nullable','string'],
        ];
    }
}
