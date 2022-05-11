<?php

namespace App\Web\Authentication\Controllers;

use App\Web\Authentication\FormRequests\StoreLoginRequest;
use Domain\User\DataTransferObjects\LoginUserData;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\ResponseFactory;

class LoginController
{
    public function __construct(
        private readonly ResponseFactory $inertiaFactory,
    ) {
    }

    public function create(): Response
    {
        return $this->inertiaFactory->render('Auth/Login');
    }

    public function store(LoginUserData $data, Request $request): RedirectResponse
    {
        if (Auth::attempt($data->toArray())) {
            $request->session()->regenerate();
            return Redirect::intended('/');
        }

        return Redirect::back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function destroy(): RedirectResponse
    {
        Auth::logout();
        return Redirect::route('auth.login.create');
    }
}
