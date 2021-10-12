<?php

namespace App\Http\Controllers\Actions;

use App\Modules\Technology\TechnologyService;
use Illuminate\Http\Request;
use Illuminate\View\View;

use function view;

class IndexAction
{
    public function __invoke(TechnologyService $service, Request $request, string $section = ''): View
    {
        return view('App::landing-pages.welcome', ['technologies' => $service->getTechnologies()]);
    }
}
