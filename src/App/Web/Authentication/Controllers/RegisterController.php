<?php

namespace App\Web\Authentication\Controllers;

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

    public function store(): Response
    {

    }
}
