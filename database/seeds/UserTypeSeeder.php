<?php

use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\PetPassport\Models\User\UserType::insert([
            ['id' => 1, 'name' => 'client', 'description' => 'simple user'],
            ['id' => 2, 'name' => 'owner_breeder', 'description' => ''],
            ['id' => 3, 'name' => 'pet', 'description' => 'animal account']
        ]);
    }
}
