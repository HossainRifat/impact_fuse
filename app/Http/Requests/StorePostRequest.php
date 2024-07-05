<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
        $data = [
            'title'               => 'nullable|string|max:255',
            'description'         => 'required|string',
            'is_facebook'         => 'nullable|boolean',
            'is_twitter'          => 'nullable|boolean',
            'is_linkedin'         => 'nullable|boolean',
            'is_instagram'        => 'nullable|boolean',
            'status'              => 'required|integer',
            'photo'               => 'nullable|string',
            'is_post_immediate' => 'nullable|boolean',
            'post_time'           => 'required|timestamp|after:now',
        ];

        if ($this->is_post_immediate) {
            $data['post_time'] = 'nullable';
        }

        return $data;
    }
}
