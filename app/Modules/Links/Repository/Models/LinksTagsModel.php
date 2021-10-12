<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\Links\Repository\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LinksTagsModel extends Model
{
    /** @var string */
    protected $table = 'links_tags';

    public function links(): BelongsToMany
    {
        return $this->belongsToMany(LinksModel::class, 'links_tag_link', 'links_tag_id', 'link_id');
    }
}
