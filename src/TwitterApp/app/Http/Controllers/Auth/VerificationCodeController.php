<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationCodeMail;
use Carbon\Carbon;
use Illuminate\View\View;

class VerificationCodeController extends Controller
{
    /**
     * 認証コード入力画面を表示します。
     */
    public function create(Request $request): View
    {
        return view('auth.verify-code', ['request' => $request]);
    }

    /**
     * メールアドレスを認証済みとしてマークします。
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => ['required', 'string', 'digits:6'],
        ]);

        $user = $request->user();

        // コードが違う場合
        if($user->verification_code !== $request->code) {
            return back()->withErrors([
                'code' => '認証コードが正しくありません。',
            ]);
        }

        // 有効期限が切れている場合
        if (now()->isAfter($user->verification_code_expires_at)) {
            // TODO: ここでコードの再送信ロジックを実装することも可能です。
            return back()->withErrors([
                'code' => '認証コードの有効期限が切れています。',
            ]);
        }

        // ユーザーのメールアドレスを認証ずみにする
        if($user->hasVerifiedEmail() === false) {
            $user->markEmailAsVerified();
        }

        // 認証コードをクリアにする
        // 認証コードをクリアする
        $user->forceFill([
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ])->save();

        // ホーム画面など、認証後のページへリダイレクト
        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }

    /**
     * 認証コードを再送信します。
     */
    public function resend(Request $request): RedirectResponse
    {
        $user = $request->user();

        // 6桁の認証コードを再生成
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->forceFill([
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => Carbon::now()->addMinutes(10), // 有効期限を10分に設定
        ])->save();

        // 認証コードをメールで送信
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return back()->with('status', 'verification-link-sent');
    }
}
