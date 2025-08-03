<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\UserServiceInterface;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RegisteredUserController extends Controller
{
    // ユーザーサービスのインターフェース
    private $userService;

    /**
     * コンストラクタ
     * 
     * @param UserServiceInterface $userService ユーザーサービスのインターフェース
     */
    public function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }
    
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @param RegisterRequest $request リクエスト
     * @return RedirectResponse
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        // 6桁の認証コードを生成
        $verificationCode = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $userData = array_merge($validatedData, [
            'verification_code' => $verificationCode,
            'verification_code_expires_at' => Carbon::now()->addMinutes(10), // 有効期限を10分に設定
        ]);

        $user = $this->userService->register($userData);

        // 認証コードをメールで送信
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}
