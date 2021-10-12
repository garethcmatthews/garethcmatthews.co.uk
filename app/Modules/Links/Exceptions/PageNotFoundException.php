<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace App\Modules\Links\Exceptions;

use Exception;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewView;
use Illuminate\Http\Request;

use function view;

class PageNotFoundException extends Exception
{
    /**
     * Render 404 Page
     *
     * @param Request $request
     * @return ViewFactory|ViewView
     */
    public function render(Request $request)
    {
        return view("errors.404");
    }
}
