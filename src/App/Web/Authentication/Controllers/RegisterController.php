<?php

declare(strict_types=1);

namespace App\Web\Authentication\Controllers;

use App\Providers\RouteServiceProvider;
use Domain\User\Actions\CreateUserFromRegistrationDataAction;
use Domain\User\DataTransferObjects\RegisterUserData;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Response;
use Inertia\ResponseFactory;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RegisterController
{
    public function __construct(
        private readonly ResponseFactory $inertiaFactory,
        private readonly Dispatcher $eventDispatcher,
    ) {
    }

    public function create(): Response
    {
        return $this->inertiaFactory->render('Auth/Register');
    }

    public function store(
        RegisterUserData $data,
        CreateUserFromRegistrationDataAction $createUser,
    ): RedirectResponse {
        $user = ($createUser)($data);
        $this->eventDispatcher->dispatch(new Registered($user));

        Auth::login($user);
        return Redirect::to(RouteServiceProvider::HOME, HttpResponse::HTTP_CREATED);
    }
}
