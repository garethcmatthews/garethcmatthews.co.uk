<?php

namespace App\Http\Controllers\Actions;

use App\Modules\Projects\ProjectsService;
use Illuminate\View\View;

use function view;

class ProjectsAction
{
    public function __invoke(ProjectsService $service, string $section = ''): View
    {
        return view('App::landing-pages.projects', ['projects' => $service->getProjects()]);
    }
}
