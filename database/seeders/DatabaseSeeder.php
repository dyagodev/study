<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        UserType::firstOrCreate([
            'name' => 'common',
            'description' => 'Common system users'
        ]);

        UserType::firstOrCreate([
            'name' => 'shopkeepers',
            'description' => 'Users who use the system to get paid for sales'
        ]);
    }
}
