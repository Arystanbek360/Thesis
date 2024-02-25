<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'author'      => ['nullable', 'string'],
            'category_id' => ['nullable', 'string', 'exists:categories,id'],
            'filter'      => ['nullable', 'string'],
            'orderBy'     => ['nullable', 'string'],
            'sort'        => ['nullable', 'in:asc,desc'],
            'perPage'     => ['nullable', 'integer'],
            'page'        => ['nullable', 'integer'],
        ];
    }
}
