<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;
use Illuminate\Validation\Rules;

class RegisterRequest extends FormRequest
{
    /**
     * バリデーションルール
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required', 
                'string', 
                'max:255'
            ],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:'.User::class
            ],
            'password' => [
                'required', 
                'confirmed', 
                'min:8', 
                'max:12',
                Rules\Password::defaults()
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            // name関連
            'name.required' => ':attributeは必須です。',
            'name.max' => ':attributeは:max文字以内で入力してください。',

            // email関連
            'email.required' => ':attributeは必須です。',
            'email.email' => ':attributeの形式で入力してください。',
            'email.max' => ':attributeは:max文字以内で入力してください。',
            'email.unique' => ':attributeは既に使用されています。',

            // password関連
            'password.required' => ':attributeは必須です。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password.min' => ':attributeは:min文字以上で入力してください。',
            'password.max' => ':attributeは:max文字以内で入力してください。'
        ];
    }
}
