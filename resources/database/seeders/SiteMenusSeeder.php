<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

use function libxml_get_last_error;
use function libxml_use_internal_errors;
use function now;
use function simplexml_load_file;

class SiteMenusSeeder extends Seeder
{
    public function run(): void
    {
        libxml_use_internal_errors(true);
        if ($this->addMenus()) {
            $this->addMenusItems();
        }
    }

    private function addMenus(): bool
    {
        $filename = __DIR__ . '/data/menus/menus.xml';
        if (! $xml = simplexml_load_file($filename)) {
            $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            echo "***Error*** $filename\n$xmlError\n";
            return false;
        }

        $this->addMenusFromXml($xml);
        return true;
    }

    private function addMenusFromXml(SimpleXMLElement $xml): void
    {
        foreach ($xml->menu as $menu) {
            DB::table('menus')->insert([
                'id'         => (int) $menu->id,
                'name'       => (string) $menu->name,
                'active'     => (int) $menu->active,
                'created_at' => now(),
            ]);
        }
    }

    private function addMenusItems(): void
    {
        $filenames = [
            __DIR__ . '/data/menus/menu-items_main-menu.xml',
        ];
        foreach ($filenames as $filename) {
            if ($xml = simplexml_load_file($filename)) {
                $menuId = (int) $xml->menu_id;
                $this->addMenusItemsFromXml($xml, $menuId);
                continue;
            }

            $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            echo "***Error*** $filename\n$xmlError\n";
        }
    }

    private function addMenusItemsFromXml(SimpleXMLElement $xml, int $menuId, ?int $menuItemsId = null): void
    {
        $orderBy = 1;
        foreach ($xml->menu_item as $menuItem) {
            DB::table('menu_items')->insert([
                'menu_id'    => $menuId,
                'parent_id'  => $menuItemsId,
                'active'     => $menuItem->active,
                'orderby'    => $orderBy,
                'title'      => $menuItem->title,
                'routename'  => $menuItem->routename,
                'parameters' => $menuItem->parameters ?? '',
                'created_at' => now(),
            ]);

            if (isset($menuItem->menu_items)) {
                $this->addMenusItemsFromXml($menuItem->menu_items, $menuId, (int) DB::getPdo()->lastInsertId());
            }

            $orderBy++;
        }
    }
}
