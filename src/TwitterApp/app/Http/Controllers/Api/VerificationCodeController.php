<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Api\VerifyCodeRequest;
use App\Http\Requests\Api\ResendVerificationCodeRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;

class VerificationCodeController extends Controller
{
    /**
     * メールアドレスを認証済みとしてマークします。
     */
    public function verify(VerifyCodeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // FormRequestの'exists'ルールにより、ユーザーの存在は保証されています。
        $user = User::where('email', $validated['email'])->firstOrFail();

        // ユーザーが存在しない、またはコードが一致しない場合
        if ($user->verification_code !== $validated['code']) {
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
    public function resend(ResendVerificationCodeRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // FormRequestの'exists:users,email'ルールにより、
        // この時点で$userは必ず存在することが保証されています。
        // 存在しない場合は、FormRequestが自動的に422エラーを返します。
        // firstOrFail()は、念のため見つからない場合に例外をスローします。
        $user = User::where('email', $validated['email'])->firstOrFail();

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
