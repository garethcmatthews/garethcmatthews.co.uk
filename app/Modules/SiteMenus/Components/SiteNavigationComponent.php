<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace App\Modules\SiteMenus\Components;

use App\Modules\SiteMenus\SiteMenusService;
use Illuminate\View\Component;
use Illuminate\View\View;

use function view;

class SiteNavigationComponent extends Component
{
    public array $menu;
    public string $view;
    public string $title;

    public function __construct(SiteMenusService $service, string $menu, string $view, string $title = "")
    {
        $this->menu  = $service->fetchMenu($menu);
        $this->view  = $view;
        $this->title = $title;
    }

    public function render(): View
    {
        return view('SiteMenus::' . $this->view);
    }
}
