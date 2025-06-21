<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\UserServiceInterface;

class RegisteredUserController extends Controller
{
    private $userService;

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
     */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = $this->userService->register($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);

        // API用レスポンス
        // return response()->json(['message' => '登録成功　メールを確認しくてください。', 'user' => $user]);
    }
}
