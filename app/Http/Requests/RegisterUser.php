<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RegisterUser extends FormRequest
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
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'password'=>'required'
        ];
    }

    public function failedValidation(Validator $validator)  
    {
        throw new HttpResponseException(response()->json([
            'success'=>false,
            'statut_code'=>422,
            'error'=>true,
            'message'=>'Erreur de validation',
            'errorsList'=>$validator->errors()
        ]));
    }

    public function messages(){
        return [
            'name.required'=>'Un nom doit etre fourni',
            'email.required'=>'Un email doit etre fourni',
            'email.unique'=>'Cette email existe deja',
            'password.required'=>'Le mot de passe est requis'
        ];
    }
}
