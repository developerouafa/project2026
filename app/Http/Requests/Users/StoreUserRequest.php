<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // validations
        return [
            'nameen' => 'required|unique:users,name->en',
            'namear' => 'required|unique:users,name->ar',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles_name' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nameen.required' =>__('Dashboard/users.nameenrequired'),
            'nameen.unique' =>__('Dashboard/users.nameenunique'),
            'namear.required' =>__('Dashboard/users.namearrequired'),
            'namear.unique' =>__('Dashboard/users.namearunique'),
            'email.required' =>__('Dashboard/users.emailrequired'),
            'email.unique' =>__('Dashboard/users.emailunique'),
            'password.required' =>__('Dashboard/users.passwordrequired'),
            'password.same' =>__('Dashboard/users.passwordsame'),
            'roles_name.required' =>__('Dashboard/users.rolesnamerequired'),
            'phone.required' =>__('Dashboard/users.phonerequired'),
        ];
    }
}
