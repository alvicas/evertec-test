<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'product_id' => 'required|integer|exists:products,id',
            'customer_name' => 'required|string|max:80',
            'customer_email' => 'required|string|email:rfc,dns|max:120',
            'customer_mobile' => 'required|string|max:40',
            'customer_document_number' => 'required|string|max:20',
            'customer_document_type' => 'required|string|max:5',
            'total' => 'required|integer'
        ];
    }
}
