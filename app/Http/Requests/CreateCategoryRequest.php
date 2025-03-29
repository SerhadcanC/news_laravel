<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'main_category_id' => 'required|integer|exists:main_categories,id',
            'image_id' => 'required|integer|exists:images,id',
            'slug' => 'required|string|min:3|max:255|unique:categories,slug'
        ];
    }

    public function messaged(): array 
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.min' => 'Name must be at least 3 characters',
            'name.max' => 'Name must be at most 255 characters',
            'main_category_id.required' => 'Main category id is required',
            'main_category_id.integer' => 'Main category id must be an integer',
            'main_category_id.exists' => 'Main category id does not exist',
            'image_id.required' => 'Image id is required',
            'image_id.integer' => 'Image id must be an integer',
            'image_id.exists' => 'Image id does not exist',
            'slug.required' => 'Slug is required',
            'slug.string' => 'Slug must be a string',
            'slug.min' => 'Slug must be at least 3 characters',
            'slug.max' => 'Slug must be at most 255 characters',
            'slug.unique' => 'Slug must be unique'
        ];
    }
}
