<?php

namespace App\Http\Requests\Web\Category;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategoryPostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255', 'required', 'unique:categories,name'],
            'status' => ['boolean', 'required'],
        ];
    }
}
