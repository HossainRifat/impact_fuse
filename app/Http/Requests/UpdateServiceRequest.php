<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'name'             => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:services,slug,' . $this->service?->id,
            'description'      => 'required|string',
            'summary'          => 'required|string',
            'tool_used'        => 'required|string',
            'parent_id'        => 'nullable|integer|exists:services,id,' . $this->service?->id,
            'status'           => 'required|integer',
            'display_order'    => 'nullable|integer',
            'photo'            => 'nullable',
            'meta_title'       => 'nullable|string|max:255',
            'meta_keywords'    => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'og_image'         => 'nullable',
        ];
    }
}
