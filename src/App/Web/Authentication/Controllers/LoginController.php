<?php

namespace App\Web\Authentication\Controllers;

use Inertia\Inertia;

class LoginController
{
    public function __construct(
        private readonly Inertia $inertia
    ) {
    }

    public function create()
    {
//        retuen $this->inertia->

        Inertia::render()
    }


}
