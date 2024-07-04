<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePageRequest extends FormRequest
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
            'title'             => 'nullable|string|max:255',
            'slug'              => 'required|string|max:255|unique:pages,slug',
            'content'           => 'required|string',
            'status'            => 'required|integer',
            'is_show_on_header' => 'nullable|boolean',
            'is_show_on_footer' => 'nullable|boolean',
            'display_order'     => 'nullable|integer',
        ];
    }
}
