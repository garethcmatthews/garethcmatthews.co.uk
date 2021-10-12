<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Links;

use App\Modules\Links\Exceptions\PageNotFoundException;
use App\Modules\Links\Repository\LinksRepository;
use Illuminate\Cache\CacheManager;
use Illuminate\Pagination\LengthAwarePaginator;

use function config;
use function explode;
use function md5;

class LinksService
{
    private LinksRepository $repository;
    private CacheManager $cache;
    private ?int $cacheTtl;
    private int $recordsPerPage;

    public function __construct(LinksRepository $repository, CacheManager $cache)
    {
        $this->repository = $repository;
        $this->cache      = $cache;

        $this->recordsPerPage = config('modules.links.paginator-records-per-page', 10);
        $this->cacheTtl       = config('modules.links.model-cache-timeout', 86400);
    }

    /**
     * Fetch all the links
     * Returns a Paginated collection ordered by link title
     *
     * @param int $currentPage The current page
     * @return LengthAwarePaginator
     */
    public function fetchAll(int $currentPage = 1): LengthAwarePaginator
    {
        $cacheName = md5(__METHOD__ . $currentPage);
        return $this->cache->remember($cacheName, $this->cacheTtl, function () use ($currentPage) {
            $paginator = $this->repository->fetchAllPaginated($this->recordsPerPage);
            if ($currentPage > $paginator->lastPage()) {
                throw new PageNotFoundException();
            }

            return $paginator;
        });
    }

    /**
     * Fetch a set of links that include all the requested tags
     * Returns a Paginated collection ordered by link title
     *
     * The tags are generated from the URL and seperated by a dash
     * i.e. php-cms would return a collection of links that have both the 'php' and 'cms' tags
     *
     * @param string $section     The tags to filter by
     * @param int    $currentPage The current page
     * @return LengthAwarePaginator
     */
    public function fetchByTags(string $section, int $currentPage = 1): LengthAwarePaginator
    {
        $cacheName = md5(__METHOD__ . $section . $currentPage);
        return $this->cache->remember($cacheName, $this->cacheTtl, function () use ($section, $currentPage) {
            $tags      = explode('-', $section);
            $paginator = $this->repository->fetchByTagsPaginated($tags, $this->recordsPerPage);
            if ($currentPage > $paginator->lastPage()) {
                throw new PageNotFoundException();
            }

            return $paginator;
        });
    }
}
