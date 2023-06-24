<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'announcement' => 'required|string',
            'content' => 'required|string',
            'author_id' => 'required|numeric|integer|exists:authors,id',
            'topics' => 'array',
            'topics.*' => 'numeric|integer|exists:topics,id',
        ];
    }
}
