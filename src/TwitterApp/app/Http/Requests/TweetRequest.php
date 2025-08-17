<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Utils\ValidationPatternsUtil as ValidationPatterns;


class TweetRequest extends FormRequest
{
    /**
     * リクエストの認可を決定
     * 
     * @return bool
     */
    public function authorize(): bool
    {
        // ログイン済みユーザーのみ許可
        // 必要に応じてポリシーやロールベースの認可を追加
        return true;
    }


    /**
     * バリデーションルール
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => [
                'required',
                'string',
                'min:1',
                'max:255',
                'regex:' . ValidationPatterns::tweetContent(),
            ],
            'image' => [
                'nullable',
                'file',
                'image',
                'mimes:jpeg,jpg,png,gif,webp', // 許可する形式を明示的に指定
                'max:2048', // 2MB = 2048KB
                'dimensions:max_width=4096,max_height=4096', // 最大解像度制限
            ],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:tweets,id',
                // 削除されていないツイートのみ許可する場合
                // Rule::exists('tweets', 'id')->where('deleted_at', null),
            ],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'content' => '投稿内容',
            'image' => '画像',
            'parent_id' => '親ツイート',
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
            // content関連
            'content.required' => ':attributeは必須です。',
            'content.min' => ':attributeを入力してください。',
            'content.max' => ':attributeは:max文字以内で入力してください。',
            'content.regex' => ':attributeには' . ValidationPatterns::getDescription(ValidationPatterns::tweetContent()) . 'のみ使用できます。',
            
            'image.image' => ':mimes ファイルのみアップロード可能です。',
            'image.max' => ':attribute サイズは2MBまでです。',
            'parent_id.exists' => '存在しない :attribute です。',
        ];
    }
}
