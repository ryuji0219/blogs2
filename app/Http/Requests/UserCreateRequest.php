<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserCreateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'newName' => 'required|max:12|min:3',
            'newPassword' => 'required|min:3',
            'newEmail' => 'required',
            'newPassword2' => 'required'
        ];
    }

    public function attributes()
    {
        return [
            'newName' => 'ユーザ名',
            'newPassword' => 'パスワード',
            'newEmail' => 'Eメール',
            'newPassword2' => '確認用パスワード'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = collect($validator->errors());
        $messages = $errors->map(function($error_messages){
            return $error_messages[0];
        });
        throw new HttpResponseException(response($messages,422));
    }
}
