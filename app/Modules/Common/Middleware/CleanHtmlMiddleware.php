<?php

namespace App\Modules\Common\Middleware;

use Closure;
use Illuminate\Http\Request;

use function preg_replace;

class CleanHtmlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $response->setContent(preg_replace('/^ +/m', '', $response->getContent()));

        return $response;
    }
}
