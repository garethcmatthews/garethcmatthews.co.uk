<?php

namespace App\Http\Controllers\Actions;

use App\Modules\Links\LinksService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

use function request;
use function view;

class LinksAction
{
    public function __invoke(LinksService $service, string $section = ''): View
    {
        LengthAwarePaginator::useBootstrap();
        $page      = (int) request()->get('page', 1);
        $paginator = empty($section) ? $service->fetchAll($page) : $service->fetchByTags($section, $page);

        return view('App::landing-pages.links', ['links' => $paginator]);
    }
}
