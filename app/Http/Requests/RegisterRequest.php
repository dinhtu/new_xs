<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\RoleType;

class RegisterRequest extends FormRequest
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
        $roles = [
            RoleType::PRODUCER,
            RoleType::WHOLE_SALERS,
            RoleType::RESTAURANT
        ];

        return [
            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'password' => 'required|min:6|max:16|regex:/^[A-Za-z0-9]*$/i',
            'password_confirm' => 'required|same:password',
            'role' => [
                Rule::in($roles)
            ],
        ];
    }
}
