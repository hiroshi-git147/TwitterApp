<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes()
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
        ];
    }

    /**
     * バリデーションメッセージ
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.max' => ':attributeは:max文字以内で入力してください。',
            'email.email' => ':attributeの形式で入力してください。',
            'email.max' => ':attributeは:max文字以内で入力してください。',
            'email.unique' => ':attributeは既に使用されています。',
        ];
    }
}
