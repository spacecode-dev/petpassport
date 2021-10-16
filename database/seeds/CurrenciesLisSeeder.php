<?php

use Illuminate\Database\Seeder;

class CurrenciesLisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->delete();
        DB::table('currencies')->insert([
            ['id' => 1, 'name' => 'ruble', 'unicode_symbol_html' => '&#8381;'],
            ['id' => 2, 'name' => 'dollar', 'unicode_symbol_html' => '&#36;'],
            ['id' => 2, 'name' => 'euro', 'unicode_symbol_html' => '&#36;'],
        ]);
    }
}
