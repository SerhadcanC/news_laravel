<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
        return [
            'name' => 'nullable|string|max:255',
            'image_id' => 'nullable|integer|exists:images,id',
            'slug' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Id is required',
            'id.integer' => 'Id must be an integer',
            'id.exists' => 'Id does not exist',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be at most 255 characters',
            'description.string' => 'Description must be a string',
            'title.string' => 'Title must be a string',
            'slug.string' => 'Slug must be a string',
            'image_id.integer' => 'Image id must be an integer',
            'image_id.exists' => 'Image id does not exist'
        ];
    }
}
