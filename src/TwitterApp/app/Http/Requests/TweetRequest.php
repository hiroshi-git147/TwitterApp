<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class TweetRequest extends FormRequest
{
    /**
     * 特定の条件でバリデーション自体を止めたい場合（例：管理者だけ許可など）
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        // 投稿はログイン済み前提なのでtrueでOK（ポリシーで制限するならfalseでも可）
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
            'content' => [
                'required',
                'string',
                'max:255',
                // 'japanese',
            ],
            'image' => 'nullable|image|max:2048',
            'parent_id' => 'nullable|integer|exists:tweets,id',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => '内容は必須です。',
            'content.max' => '内容は255文字以内で入力してください。',
            'content.regex' => '内容は日本語と一部の記号（、。・「」『』！？ー）のみで入力してください。',
            'image.image' => '画像ファイルのみアップロード可能です。',
            'image.max' => '画像サイズは2MBまでです。',
            'parent_id.exists' => '存在しない親ツイートです。',
        ];
    }
}
