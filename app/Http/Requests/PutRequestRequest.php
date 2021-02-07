<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PutRequestRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tvdb_id' => 'integer|required_without:item.tmdb_id',
            'tmdb_id' => 'integer|required_without:item.tvdb_id',
            'text'    => 'required',
            'images'  => 'present|array',
        ];
    }
}
