<?php

namespace App\Http\Requests;

class ValidationList
{
    /**
     * 日本語（ひらがな、カタカナ、漢字）と一般的な句読点・記号の正規表現文字セットを返します。
     *
     * @return string
     */
    public static function japaneseChars(): string
    {
        // \p{Han}: CJK統合漢字
        // \p{Hiragana}: ひらがな
        // \p{Katakana}: カタカナ
        // 、。・「」『』！？ー: 日本語の句読点と記号
        // \s: 空白文字
        return 'regex:\p{Han}\p{Hiragana}\p{Katakana}、。・「」『』！？ー\s';
    }

    /**
     * 英語（半角アルファベット）の正規表現文字セットを返します。
     *
     * @return string
     */
    public static function englishChars(): string
    {
        return 'regex:a-zA-Z';
    }

    /**
     * 数字（半角）の正規表現文字セットを返します。
     *
     * @return string
     */
    public static function numericChars(): string
    {
        return 'regex:0-9';
    }
}
