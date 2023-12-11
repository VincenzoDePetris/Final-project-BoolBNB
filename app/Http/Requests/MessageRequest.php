<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'=> 'required|email|max:1',
            'name'=> 'required|string',
            'text'=> 'required'


        ];
    }
    public function message(){
        return[
            'email.required' => 'La Mail è obbligatoria',
            'email.email' => 'Il titolo deve essere una mail',

            'name.required' => 'il nome è obbligatoria',
            'name.string' => 'Il titolo deve essere una stringa',

            'text.required' => 'il Messaggio è obbligatoria',


        ];
    }
}