<?php

/**
 * Website project: garethcmatthews.co.uk
 *
 * @link        https://github.com/garethcmatthews/garethcmatthews.co.uk
 * @copyright   Copyright (c) Gareth C Matthews
 * @license     https://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

declare(strict_types=1);

namespace App\Modules\SiteMenus\Repository;

use App\Modules\SiteMenus\Repository\Models\MenuItemsModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class SiteMenusRepository
{
    /**
     * Fetch the menu collection
     *
     * @param string $menu The menu name to return
     * @return Collection
     */
    public function fetchMenu(string $menu): Collection
    {
        return $this->buildTree($this->fetchMenuItems($menu), null);
    }

    /**
     * Fetch Menu Items from the database
     *
     * @param string $menu The Menu name
     * @return EloquentCollection
     */
    private function fetchMenuItems(string $menu): EloquentCollection
    {
        return MenuItemsModel::query()
            ->select('menu_items.*')
            ->join('menus', 'menus.id', '=', 'menu_items.menu_id')
            ->where('menus.name', $menu)
            ->where('menus.active', 1)
            ->where('menu_items.active', 1)
            ->orderBy('menu_items.parent_id')
            ->orderBy('menu_items.orderby')
            ->get();
    }

    /**
     * Rescurse through the Menu Items table and return a Parent/Child Tree
     *
     * @param EloquentCollection $collection
     * @param integer|null       $parentId
     * @return Collection
     */
    private function buildTree(EloquentCollection $collection, ?int $parentId): Collection
    {
        $branch = new Collection();
        foreach ($collection as $model) {
            if ($model->parent_id === $parentId) {
                $children = $this->buildTree($collection, $model->id);
                if ($children->count() > 0) {
                    $model->setChildrenAttribute($children);
                }
                $branch->add($model);
            }
        }

        return $branch;
    }
}
