<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function libxml_get_last_error;
use function now;
use function simplexml_load_file;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        $this->addBlockedList();
    }

    private function addBlockedList(): bool
    {
        $filename = __DIR__ . '/data/contact/blocked.xml';
        if (! $xml = simplexml_load_file($filename)) {
            $xmlError = libxml_get_last_error() === false ? 'Unknown error' : libxml_get_last_error()->message;
            echo "***Error*** $filename\n$xmlError\n";
            return false;
        }

        foreach ($xml->email as $email) {
            DB::table('contact_blocked_list')->insert([
                'email'      => (string) $email,
                'created_at' => now(),
            ]);
        }

        return true;
    }
}
