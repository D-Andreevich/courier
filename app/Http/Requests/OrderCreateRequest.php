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
            'width' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'depth' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|int|min:1',
            'time_of_receipt' => 'required|',
            'name_receiver' => 'required|string|max:150',
            'phone_receiver' => 'required|string|max:50',
            'email_receiver' => 'required|email',
            'address_a' => 'required|string|max:150',
            'coordinate_a' => 'required|string|max:50',
            'address_b' => 'required|string|max:150',
            'coordinate_b' => 'required|string|max:50',
            'distance' => 'required|numeric',
            'price' => 'required|numeric|min:0',
        ];
    }
}
