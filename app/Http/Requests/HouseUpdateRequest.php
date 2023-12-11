<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HouseUpdateRequest extends FormRequest
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
            // 'user_id'=>'required|exists:users,id',
            'title' => 'required|string|min:2|max:200',
            'address' => 'required|string|min:2|',
            'description' => 'required|string|min:10|max:500',
            'sq_meters' => 'required|integer|min:1',
            'rooms' => 'required|integer|min:1',
            'beds' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'cover_image' => 'image',
            'extras' => ['nullable', 'exists:extras,id'],        
            ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Il titolo è obbligatorio',
            'title.string' => 'Il titolo deve essere una stringa',
            'title.min' => 'Il titolo deve avere minimo 2 caratteri',
            'title.max' => 'Il titolo può avere massimo 200 caratteri',

            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.string' => 'L\'indirizzo deve essere una stringa',
            'address.min' => 'L\'indirizzo deve avere minimo 2 caratteri',

            'description.required' => 'La descrizione è obbligatoria',
            'description.string' => 'La descrizione deve essere una stringa',
            'description.min' => 'La descrizione deve avere minimo 10 caratteri',
            'description.max' => 'La descrizione può avere massimo 500 caratteri',

            'sq_meters.required' => 'Il numero di metri quadri è obbligatorio',
            'sq_meters.integer' => 'Il numero di metri quadri deve essere un numero',
            'sq_meters.min' => 'Il numero di metri quadri deve essere minimo uno',

            'rooms.required' => 'Il numero di stanze è obbligatorio',
            'rooms.integer' => 'Il numero di stanze deve essere un numero',
            'rooms.min' => 'Il numero di stanze deve essere minimo uno',

            'beds.required' => 'Il numero di letti è obbligatorio',
            'beds.integer' => 'Il numero di letti deve essere un numero',
            'beds.min' => 'Il numero di letti deve essere minimo uno',

            'bathrooms.required' => 'Il numero di bagni è obbligatorio',
            'bathrooms.integer' => 'Il numero di bagni deve essere un numero',
            'bathrooms.min' => 'Il numero di bagni deve essere minimo uno',

            'cover_image.image' => 'Il file caricato deve essere un\' immagine',

            'extras.exists' => 'I servizi inseriti non sono validi',


            

            'url.required' => 'L\'url è obbligatorio',
            'url.string' => 'L\'url deve essere una stringa',
        ];
    }
}