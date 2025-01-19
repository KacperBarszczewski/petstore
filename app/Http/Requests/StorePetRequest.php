<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|array',
            'photoUrls.*' => 'string|url',
            'id' => 'nullable|integer',
            'category.id' => 'nullable|integer',
            'category.name' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*.id' => 'nullable|integer',
            'tags.*.name' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:available,pending,sold',
        ];
    }
}

