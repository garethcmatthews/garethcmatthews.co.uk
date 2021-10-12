<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\SiteMenus;

use App\Modules\SiteMenus\Repository\SiteMenusRepository;
use Illuminate\Cache\CacheManager;

use function config;
use function md5;

class SiteMenusService
{
    private SiteMenusRepository $repository;
    private CacheManager $cache;
    public ?int $cacheTtl;

    public function __construct(SiteMenusRepository $repository, CacheManager $cacheManager)
    {
        $this->repository = $repository;
        $this->cache      = $cacheManager;

        $this->cacheTtl = config('modules.sitemenus.model-cache-timeout', 86400);
    }

    /**
     * Fetch the menu collection
     *
     * @param string $menu The menu name to return
     * @return array
     */
    public function fetchMenu(string $menu): array
    {
        $cacheName = md5(__METHOD__ . $menu);
        return $this->cache->remember($cacheName, $this->cacheTtl, function () use ($menu) {
            return $this->repository->fetchMenu($menu)->toArray();
        });
    }
}
