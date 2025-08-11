<?php

namespace App\Utils;

/**
 * バリデーション用の正規表現パターン集
 */
class ValidationPatternsUtil
{
    /**
     * 日本語（ひらがな、カタカナ、漢字）+ 基本記号
     */
    public const JAPANESE_WITH_SYMBOLS = '/^[ぁ-んァ-ヶー一-龯々〇〻a-zA-Z0-9０-９、。・「」『』！？（）()【】\[\]：:；;…‥\s\r\n]+$/';

    /**
     * 日本語のみ（記号なし）
     */
    public const JAPANESE_ONLY = '/^[ぁ-んァ-ヶー一-龯々〇〻]+$/';

    /**
     * ひらがなのみ
     */
    public const HIRAGANA_ONLY = '/^[ぁ-ん]+$/';

    /**
     * カタカナのみ
     */
    public const KATAKANA_ONLY = '/^[ァ-ヶー]+$/';

    /**
     * 漢字のみ
     */
    public const KANJI_ONLY = '/^[一-龯々〇〻]+$/';

    /**
     * 英数字のみ
     */
    public const ALPHANUMERIC = '/^[a-zA-Z0-9]+$/';

    /**
     * 半角英数字 + ハイフン、アンダースコア（ユーザー名など）
     */
    public const USERNAME = '/^[a-zA-Z0-9_-]+$/';

    /**
     * 郵便番号（123-4567形式）
     */
    public const POSTAL_CODE = '/^\d{3}-\d{4}$/';

    /**
     * 電話番号（ハイフンあり・なし両対応）
     */
    public const PHONE_NUMBER = '/^0\d{1,4}-?\d{1,4}-?\d{3,4}$/';

    /**
     * 携帯電話番号
     */
    public const MOBILE_PHONE = '/^0[789]0-?\d{4}-?\d{4}$/';

    /**
     * パスワード（英数字含む8文字以上）
     */
    public const PASSWORD_MEDIUM = '/^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d@$!%*?&]{8,}$/';

    /**
     * パスワード（英大小数字記号含む8文字以上）
     */
    public const PASSWORD_STRONG = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';

    /**
     * URL（簡易版）
     */
    public const URL_SIMPLE = '/^https?:\/\/[\w\-._~:\/?#[\]@!$&\'()*+,;=%]+$/';

    /**
     * 日本の銀行口座番号（7桁）
     */
    public const BANK_ACCOUNT = '/^\d{7}$/';

    /**
     * クレジットカード番号（ハイフンあり・なし）
     */
    public const CREDIT_CARD = '/^\d{4}-?\d{4}-?\d{4}-?\d{4}$/';

    /**
     * パターンの説明を取得
     * 
     * @param string $pattern
     * @return string
     */
    public static function getDescription(string $pattern): string
    {
        $descriptions = [
            self::JAPANESE_WITH_SYMBOLS => '日本語、英数字、基本的な記号',
            self::JAPANESE_ONLY => '日本語のみ',
            self::HIRAGANA_ONLY => 'ひらがなのみ',
            self::KATAKANA_ONLY => 'カタカナのみ',
            self::KANJI_ONLY => '漢字のみ',
            self::ALPHANUMERIC => '半角英数字のみ',
            self::USERNAME => '半角英数字、ハイフン、アンダースコアのみ',
            // self::POSTAL_CODE => '郵便番号（123-4567形式）',
            self::PHONE_NUMBER => '電話番号',
            self::MOBILE_PHONE => '携帯電話番号',
            self::PASSWORD_MEDIUM => '英数字を含む8文字以上',
            self::PASSWORD_STRONG => '英大文字、小文字、数字、記号を含む8文字以上',
            self::URL_SIMPLE => 'URL形式',
            // self::BANK_ACCOUNT => '銀行口座番号（7桁）',
            // self::CREDIT_CARD => 'クレジットカード番号',
        ];

        return $descriptions[$pattern] ?? '不明なパターン';
    }

    /**
     * よく使う組み合わせパターン
     */
    public static function tweetContent(): string
    {
        return self::JAPANESE_WITH_SYMBOLS;
    }

    public static function userDisplayName(): string
    {
        return self::JAPANESE_WITH_SYMBOLS;
    }

    public static function userLoginId(): string
    {
        return self::USERNAME;
    }
}
