<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function libxml_get_last_error;
use function libxml_use_internal_errors;
use function now;
use function simplexml_load_file;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        libxml_use_internal_errors(true);
        $this->addProjects();
    }

    private function addProjects(): bool
    {
        $filename = __DIR__ . '/data/projects/projects.xml';
        if (! $xml = simplexml_load_file($filename)) {
            $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            echo "***Error*** $filename\n$xmlError\n";
            return false;
        }

        $orderBy = 1;
        foreach ($xml->project as $project) {
            DB::table('projects')->insert([
                'title'       => (string) $project->title,
                'description' => (string) $project->description,
                'image'       => (string) $project->image,
                'isgithub'    => (int) $project->isgithub,
                'url'         => (string) $project->url,
                'orderby'     => $orderBy,
                'active'      => (int) $project->active,
                'created_at'  => now(),
            ]);

            $orderBy++;
        }

        return true;
    }
}
