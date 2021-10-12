<?php

namespace App\Modules\Common\Middleware;

use Closure;
use Illuminate\Cache\CacheManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HTTPResponse;

use function config;
use function md5;
use function response;

class PageCacheMiddleware
{
    private CacheManager $cache;
    private ?int $cacheTtl;

    public function __construct(CacheManager $cache)
    {
        $this->cache    = $cache;
        $this->cacheTtl = config('modules.common.fullpage-cache-timeout');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $cachename = md5($request->fullUrl());
        if ($this->cache->store()->has($cachename)) {
            return response($this->cache->store()->get($cachename));
        }

        return $next($request);
    }

    /**
     * Cache on terminate
     *
     * @param Request $request
     * @param HTTPResponse $response
     * @return mixed
     */
    public function terminate(Request $request, HTTPResponse $response)
    {
        $cachename = md5($request->fullUrl());
        if ($this->cache->store()->has($cachename) === false) {
            $this->cache->store()->put($cachename, $response->getContent(), $this->cacheTtl);
        }
    }
}
