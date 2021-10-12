<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Technology;

use App\Modules\Technology\Repository\TechnologyRepository;
use Illuminate\Cache\CacheManager;

use function config;
use function md5;

class TechnologyService
{
    private CacheManager $cache;
    private TechnologyRepository $repository;
    public ?int $cacheTtl;

    public function __construct(TechnologyRepository $repository, CacheManager $cacheManager)
    {
        $this->repository = $repository;
        $this->cache      = $cacheManager;
        $this->cacheTtl   = config()->get('modules.sitemenus.model-cache-timeout', null);
    }

    /**
     * Fetch the technologies
     * Returns an array of Technologies types and items
     *
     * @return array
     */
    public function getTechnologies(): array
    {
        $cacheName = md5(__METHOD__);
        return $this->cache->remember($cacheName, $this->cacheTtl, function () {
            return $this->repository->fetchAllTechnologies()->groupBy('tag')->toArray();
        });
    }
}
