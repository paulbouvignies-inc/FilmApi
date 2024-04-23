<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Validator;

class StoreFilmRequest extends FormRequest
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
            'nom' => ['required', 'string', 'max:128'],
            'synopsis' => ['nullable', 'string', 'max:2048'],
            'note' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'date_de_sortie' => ['nullable', 'date'],
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array{
        return [
            'nom.required' => 'Le nom est obligatoire',
            'nom.max' => 'Le nom doit faire moins de 128 caractères',
            'synopsis.required' => 'Le synopsis est obligatoire',
            'synopsis.max' => 'Le synopsis doit faire moins de 2048 caractères',
            'note.required' => 'La note est obligatoire',
            'date_de_sortie.required' => 'La date de sortie est obligatoire',
            'note.numeric' => 'La note doit être un nombre',
            'note.min' => 'La note doit être supérieure ou égale à 0',
            'note.max' => 'La note doit être inférieure ou égale à 5',
            'date_de_sortie.date' => 'La date de sortie doit être une date',
            'poster.image' => 'Le poster doit être une image',
            'poster.mimes' => 'Le poster doit être une image de type jpeg, png, jpg, gif ou svg',
            'poster.max' => 'Le poster doit faire moins de 2048 ko'
        ];
    }

    public function failedValidation(Validator|\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ], 422));
    }
}
