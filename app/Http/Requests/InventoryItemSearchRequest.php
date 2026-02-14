<?php

declare(strict_types=1);

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InventoryItemSearchRequest extends FormRequest
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
            'search_word'  => ['nullable','string','max:100'],
            'min_price'    => ['nullable','numeric','min:0'],
            'max_price'    => ['nullable','numeric','min:0'],
            'limit'        => ['nullable','integer','min:1','max:100'],
            'sort'         => ['nullable','string', Rule::in(['id','name','sku','created_at'])],
            'direction'    => ['nullable','string', Rule::in(['asc','desc'])],         
        ];
    }
}
