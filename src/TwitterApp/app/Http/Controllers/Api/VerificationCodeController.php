<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;

class VerificationCodeController extends Controller
{
    /**
     * メールアドレスを認証済みとしてマークします。
     */
    public function verify(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'code' => ['required', 'string', 'digits:6'],
        ], [
            'email.required' => 'メールアドレスが存在しません。',
            'email.email'    => '有効なメールアドレス形式ではありません。',
            'code.required' => '認証コードを入力してください。',
            'code.digits'   => '認証コードは6桁の数字で入力してください。',
        ]);

        $user = User::where('email', $request->email)->first();

        // ユーザーが存在しない、またはコードが一致しない場合
        // ユーザーが存在しないことを悟られないように、同じエラーメッセージを返す
        if (!$user || $user->verification_code !== $request->code) {
            return response()->json(['message' => '認証コードが正しくありません。'], 422);
        }

        if (Carbon::now()->isAfter($user->verification_code_expires_at)) {
            return response()->json(['message' => '認証コードの有効期限が切れています。'], 422);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        $user->forceFill([
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ])->save();

        return response()->json(['message' => '認証に成功しました。']);
    }

    /**
     * 認証コードを再送信します。
     */
    public function resend(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            
        ], [
            'email.required' => 'メールアドレスが存在しません。',
            'email.email'    => '有効なメールアドレス形式ではありません。',
        ]);

        $user = User::where('email', $request->email)->first();

        // ユーザーが存在しない場合でも、成功したかのようなレスポンスを返し、
        // メールアドレスの存在を推測させないようにする
        if (!$user) {
            return response()->json(['message' => '認証コードを送信しました。']);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(['message' => 'すでに認証済みです。'], 400);
        }

        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $newExpiration = Carbon::now()->addMinutes(10);

        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => $newExpiration,
        ])->save();

        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return response()->json(['message' => '新しい認証コードを送信しました。']);
    }
}
