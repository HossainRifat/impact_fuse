<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
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
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:blogs,slug,' . $this->blog->id,
            'categories'       => 'required|array',
            'categories.*'     => 'required|exists:blog_categories,id',
            'content'          => 'required|string',
            'status'           => 'required|integer',
            'is_show_on_home'  => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'photo'            => 'nullable',
            'og_image'         => 'nullable',
            'start_date'       => 'nullable|date',
            'end_date'         => 'nullable|date|after:start_date',
            'summary'          => 'required|string',
            'tag'              => 'required|string',
        ];
    }
}
