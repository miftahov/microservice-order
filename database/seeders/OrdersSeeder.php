<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class OrdersSeeder extends Seeder
{
    /**
     * Запустить наполнение базы данных.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert([
            'uuid'      => Str::uuid(),
            'userUuid'  => Str::uuid(),
            'phone'     => '12345678901',
            'status'    => 'created',
        ]);
    }
}
