<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class ClientCreateRequest extends FormRequest
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
            'id' => ['present', 'nullable', 'regex:/^[a-zA-Z0-9]*([a-zA-Z][0-9]|[0-9][a-zA-Z])[a-zA-Z0-9]*$/i', 'min:6', 'max:6'],
            'name' => 'required',
            'address' => 'required',
            'email' => 'required|email|unique:clients,email',
            'contactPersons' => 'nullable|array',
            'contactPersons.*' => 'nullable|integer|exists:users,id'
        ];
    }
}
