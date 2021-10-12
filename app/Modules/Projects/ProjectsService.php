<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Projects;

use App\Modules\Projects\Repository\ProjectsRepository;
use Illuminate\Cache\CacheManager;

use function config;
use function md5;

class ProjectsService
{
    private CacheManager $cache;
    private ProjectsRepository $repository;
    public ?int $cacheTtl;

    public function __construct(ProjectsRepository $repository, CacheManager $cacheManager)
    {
        $this->repository = $repository;
        $this->cache      = $cacheManager;
        $this->cacheTtl   = config()->get('module-projects.model-cache-timeout', null);
    }

    /**
     * Fetch the Projects
     * Returns an array of Projects
     *
     * @return array
     */
    public function getProjects(): array
    {
        $cacheName = md5(__METHOD__);
        return $this->cache->remember($cacheName, $this->cacheTtl, function () {
            return $this->repository->fetchAllProjects()->toArray();
        });
    }
}
