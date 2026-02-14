<?php

declare(strict_types=1);

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StockTransferSearchRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'from_warehouse_id' => ['nullable','integer'],
            'to_warehouse_id'   => ['nullable','integer'],
            'inventory_item_id' => ['nullable','integer'],
            'limit'             => ['nullable','integer','min:1','max:100']
        ];
    }
}
