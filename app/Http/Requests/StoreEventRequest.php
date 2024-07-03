<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
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
            'slug'             => 'required|string|max:255|unique:events,slug',
            'categories'       => 'required|array',
            'categories.*'     => 'required|exists:event_categories,id',
            'content'          => 'required|string',
            'status'           => 'required|integer',
            'video_url'        => 'nullable|max:255',
            'is_show_on_home'  => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:255',
            'photo'            => 'required|string',
            'og_image'         => 'nullable|string',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date|after:start_date',
            'summary'          => 'required|string',
            'tag'              => 'required|string',
        ];
    }
}
