<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'link'        => 'nullable|string',
            'video_url'   => 'nullable|string',
            'sort_order'  => 'required|integer',
            'location'    => 'required|integer',
            'status'      => 'required|integer',
            'type'        => 'required|string',
            'photo'       => 'nullable|string',
        ];
    }
}
