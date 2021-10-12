<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SimpleXMLElement;

use function chr;
use function file_exists;
use function libxml_get_last_error;
use function libxml_use_internal_errors;
use function now;
use function ord;
use function simplexml_load_file;

class LinksSeeder extends Seeder
{
    private string $error;

    /** @var array <string, int> */
    private array $tagIds;

    public function run(): void
    {
        libxml_use_internal_errors(true);
        if (! $this->addTags()) {
            echo $this->error;
            return;
        }

        $this->addLinks();
    }

    private function addTags(): bool
    {
        if (! $xml = $this->loadXmlFromFile(__DIR__ . '/data/links/links-tags.xml')) {
            return false;
        }

        foreach ($xml->tag as $tag) {
            $name                = (string) $tag->name;
            $title               = (string) $tag->title;
            $insertId            = DB::table('links_tags')->insertGetId(['name' => $name, 'title' => $title, 'created_at' => now()]);
            $this->tagIds[$name] = $insertId;
        }

        return true;
    }

    private function addLinks(): void
    {
        for ($i = ord('A'); $i <= ord('Z'); $i++) {
            $filename = __DIR__ . '/data/links/links_' . chr($i) . '.xml';
            if (! file_exists($filename)) {
                continue;
            }

            if (! $xml = $this->loadXmlFromFile($filename)) {
                echo $this->error;
                continue;
            }

            foreach ($xml->link as $link) {
                $linkId = DB::table('links')->insertGetId([
                    'title'       => (string) $link->title,
                    'description' => (string) $link->description,
                    'url'         => (string) $link->url,
                    'image'       => (string) $link->image,
                    'active'      => 1,
                    'created_at'  => now(),
                ]);

                $this->addLinksTags($link->tags, $linkId);
            }
        }
    }

    private function addLinksTags(SimpleXMLElement $tags, int $linkId): void
    {
        foreach ($tags->tag as $tag) {
            $linksTagsId = $this->tagIds[(string) $tag];
            DB::table('links_tag_link')->insert(['link_id' => $linkId, 'links_tag_id' => $linksTagsId]);
        }
    }

    private function loadXmlFromFile(string $filename): ?SimpleXMLElement
    {
        if (! $xml = simplexml_load_file($filename)) {
            $xmlError    = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            $this->error = "***Error*** $filename\n$xmlError\n";
            return null;
        }

        return $xml;
    }
}
