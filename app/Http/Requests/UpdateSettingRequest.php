<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'key'    => 'required|string|max:255|unique:settings,key,' . $this->setting->id,
            'value'  => 'required|string',
            'type'   => 'required|integer',
            'status' => 'required|integer',
        ];
    }
}
