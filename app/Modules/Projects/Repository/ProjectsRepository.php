<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Projects\Repository;

use App\Modules\Projects\Repository\Models\ProjectsModel;
use Illuminate\Database\Eloquent\Collection;

class ProjectsRepository
{
    /**
     * Fetch the projects collection
     *
     * @return Collection
     */
    public function fetchAllProjects(): Collection
    {
        return ProjectsModel::query()
            ->where('active', '=', 1)
            ->orderBy('orderBy')
            ->get();
    }
}
