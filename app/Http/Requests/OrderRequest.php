<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            'firstname' => 'required|string|max:1024',
            'secondname' => 'required|string|max:1024',
            'email' => 'required|email',
            'phone' => 'required|string|max:1024',
            'education' => 'required|integer|min:1|max:3',
        ];
    }
}
