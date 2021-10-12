<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Technology\Repository;

use App\Modules\Technology\Repository\Models\TechnologyModel;
use Illuminate\Database\Eloquent\Collection;

class TechnologyRepository
{
    /**
     * Fetch the technology collection
     *
     * @return Collection
     */
    public function fetchAllTechnologies(): Collection
    {
        return TechnologyModel::with([
            "items" => function ($query) {
                $query->where("active", "=", 1);
            },
        ])->where("active", "=", 1)
            ->orderBy('tag')
            ->get();
    }
}
