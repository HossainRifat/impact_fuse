<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\Phone;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    final public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    final public function rules(): array
    {
        return [
            'name'        => 'required|string:max:255',
            'email'       => 'required|email|max:255|unique:users,email,' . $this->route('user')->id,
            'phone'       => ['required', new Phone],
            'status'      => 'required|numeric|in:' . implode(',', array_keys(User::STATUS_LIST)),
            'password'    => 'nullable|string|min:8',
            'role_id'     => 'required|array|exists:roles,id',
        ];
    }
}
