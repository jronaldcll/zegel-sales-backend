<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     * Custom validation message
     */
    public function messages(): array
    {
        return [
            'client.required' => 'Please give the client value',
            'operation_date.required' => 'Please give the operation_date value',
            'expiration_date.required' => 'Please give the expiration_date value',
            'payment_condition.required' => 'Please give the payment_condition value',
            'currency.required' => 'Please give the currency value',
            'sale_detail.required' => 'Please give the sale_detail value',
            'subtotal.required' => 'Please give the subtotal value',
            'igv.required' => 'Please give the igv value',
            'total.required' => 'Please give the total value'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'client' => 'required|max:255',
            'operation_date' => 'required',
            'expiration_date' => 'required',
            'payment_condition' => 'required',
            'currency' => 'required|max:3',
            'sale_detail' => 'required',
            'subtotal' => 'required|numeric',
            'igv' => 'required|numeric',
            'total' => 'required|numeric',
        ];
    }
}
