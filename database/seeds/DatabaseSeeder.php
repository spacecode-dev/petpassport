<?php

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
//         $this->call(CurrenciesLisSeeder::class);
         $this->call(MarketCategoriesTableSeeder::class);
         $this->call(UserTypeSeeder::class);
    }
}
