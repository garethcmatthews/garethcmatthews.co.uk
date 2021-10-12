<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Technology\Repository\Models;

use App\Modules\Technology\Repository\Models\TechnologyItemsModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TechnologyModel extends Model
{
    /** @var string */
    protected $table = 'technology';

    public function items(): HasMany
    {
        return $this->hasMany(TechnologyItemsModel::class, 'technology_id', 'id')->orderBy('orderby');
    }
}
