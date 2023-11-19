<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Factory;
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
        //Tạo dữ liệu mẫu
        // \App\Models\User::factory(10)->create();
        $this ->call([StudentSeeder::class,Userseeder::class]);

        
    }
}
