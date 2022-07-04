<?php

namespace Tests\Feature\Web\Uptime\PingController;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PingController
{
    public function index(Request $request): Response
    {
        return Inertia::render('Uptime/Ping/Index');
    }
}
