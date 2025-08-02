<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationCodeController extends Controller
{
    /**
     * 認証コード入力画面を表示します。
     * 
     * @param Request $request リクエスト
     * @return View
     */
    public function create(Request $request): View
    {
        return view('auth.verify-code', [
            'request' => $request,
            'email' => $request->user()->email,
        ]);
    }
}
