<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestComment extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check() && (\Auth::user()->hasRole('administrator') || \Auth::user()->hasRole('moderator')); // sprawdzenie autoryzacji przy walidacji
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'tutorialComment' => 'required|max:1000',
        ];
    }
}
