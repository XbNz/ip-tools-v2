<?php

namespace App\Web\Uptime\Controllers;

use Inertia\Inertia;

class UptimeController
{
    public function __invoke()
    {
        return Inertia::render('Uptime/Index');
    }
}
