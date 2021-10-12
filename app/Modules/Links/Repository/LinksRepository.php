<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Links\Repository;

use App\Modules\Links\Repository\Models\LinksModel;
use Illuminate\Pagination\LengthAwarePaginator;

use function count;

class LinksRepository
{
    /**
     * Fetch all the links
     * Returns a Paginated collection ordered by link title
     *
     * @param int $recordsPerPage The paginators records per page setting
     * @return LengthAwarePaginator
     */
    public function fetchAllPaginated(int $recordsPerPage = 10): LengthAwarePaginator
    {
        return LinksModel::query()
            ->select('links.*')
            ->orderBy('title')
            ->where('links.active', 1)
            ->paginate($recordsPerPage);
    }

    /**
     * Fetch a set of links that include all the requested tags
     * Returns a Paginated collection ordered by link title
     *
     * The tags are generated from the URL and seperated by a dash
     * i.e. php-cms would return a collection of links that have both the 'php' and 'cms' tags
     *
     * @param array $tags           The tags to filter by
     * @param int   $recordsPerPage The paginators records per page setting
     * @return LengthAwarePaginator
     */
    public function fetchByTagsPaginated(array $tags, int $recordsPerPage = 10): LengthAwarePaginator
    {
        return LinksModel::query()
            ->select('links.*')
            ->join('links_tag_link', 'links_tag_link.link_id', '=', 'links.id')
            ->join('links_tags', 'links_tag_link.links_tag_id', '=', 'links_tags.id')
            ->where('links.active', 1)
            ->wherein('links_tags.name', $tags)
            ->havingRaw('COUNT(links.id) = ?', [count($tags)])
            ->groupBy('links.id')
            ->paginate($recordsPerPage);
    }
}
