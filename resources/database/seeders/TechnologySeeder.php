<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

use function file_exists;
use function libxml_get_last_error;
use function libxml_use_internal_errors;
use function now;
use function simplexml_load_file;

class TechnologySeeder extends Seeder
{
    /** @var array <string, int> */
    private array $technologyTypeIds;

    public function run(): void
    {
        libxml_use_internal_errors(true);
        if ($this->addTechnology()) {
            $this->addTechnologyItems();
        }
    }

    private function addTechnology(): bool
    {
        $filename = __DIR__ . '/data/technology/technology.xml';
        if (! $xml = simplexml_load_file($filename)) {
            $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            echo "***Error*** $filename\n$xmlError\n";
            return false;
        }

        $this->addTechnologyFromXml($xml);
        return true;
    }

    private function addTechnologyFromXml(SimpleXMLElement $xml): void
    {
        foreach ($xml->type as $type) {
            $tag      = (string) $type->tag;
            $insertId = DB::table('technology')->insertGetId([
                'description' => (string) $type->description,
                'tag'         => $tag,
                'active'      => (int) $type->active,
                'created_at'  => now(),
            ]);

            $this->technologyTypeIds[$tag] = $insertId;
        }
    }

    private function addTechnologyItems(): void
    {
        foreach ($this->technologyTypeIds as $name => $technologyTypeId) {
            $filename = __DIR__ . '/data/technology/technology-' . $name . '.xml';
            if (file_exists($filename)) {
                if ($xml = simplexml_load_file($filename)) {
                    $this->addTechnologyItemsFromXml($xml, $technologyTypeId);
                    continue;
                }

                $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
                echo "***Error*** $filename\n$xmlError\n";
            }
        }
    }

    private function addTechnologyItemsFromXml(SimpleXMLElement $xml, int $technologyTypeId): void
    {
        $order = 1;
        foreach ($xml->technology as $technology) {
            DB::table('technology_items')->insert([
                'title'         => (string) $technology->title,
                'url'           => (string) $technology->url,
                'active'        => (int) $technology->active,
                'primary'       => (int) $technology->primary,
                'orderby'       => $order,
                'technology_id' => $technologyTypeId,
                'created_at'    => now(),
            ]);

            $order++;
        }
    }
}
