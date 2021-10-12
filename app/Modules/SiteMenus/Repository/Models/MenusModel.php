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
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenusModel extends Model
{
    /** @var string */
    protected $table = 'menus';

    public function items(): HasMany
    {
        return $this->hasMany(MenuItemsModel::class, 'menu_id', 'id');
    }
}
