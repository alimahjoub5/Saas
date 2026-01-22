<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CrmStageSeeder extends Seeder
{
    public function run(): void
    {
        $stages = [
            ['name' => 'New', 'order' => 1],
            ['name' => 'Qualified', 'order' => 2],
            ['name' => 'Proposal Drafted', 'order' => 3],
            ['name' => 'Sent', 'order' => 4],
            ['name' => 'Follow-up', 'order' => 5],
            ['name' => 'Call', 'order' => 6],
            ['name' => 'Won', 'order' => 7],
            ['name' => 'Lost', 'order' => 8],
        ];

        DB::table('crm_stages')->upsert($stages, ['name'], ['order']);
    }
}
