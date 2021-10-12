<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\SiteMenus\Repository\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class MenuItemsModel extends Model
{
    /** @var string */
    protected $table = 'menu_items';

    /** @var array<int, string> */
    protected $appends = ['children'];

    public function menu(): BelongsTo
    {
        return $this->belongsTo(MenusModel::class, 'menu_id');
    }

    /**
     * Get the Menus Children
     *
     * @return Collection|null
     */
    public function getChildrenAttribute(): ?Collection
    {
        return $this->attributes['children'] ?? null;
    }

    /**
     * Set the Menus Children
     *
     * @param Collection<MenusModel>|null $children
     */
    public function setChildrenAttribute(?Collection $children): void
    {
        $this->attributes['children'] = $children;
    }
}
