<?php

namespace App\Web\Authentication\Controllers;

use App\Web\Authentication\FormRequests\StoreRegisterRequest;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Inertia\ResponseFactory;

class RegisterController
{
    public function __construct(
        private readonly ResponseFactory $inertiaFactory,
    ) {
    }

    public function create(): Response
    {
        return $this->inertiaFactory->render('Auth/Register');
    }

    public function store(
        StoreRegisterRequest $request

    ): RedirectResponse {

    }
}
