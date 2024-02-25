<?php

namespace Database\Seeders;

use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Item::truncate();

        $data = [
            [
                'name'    => 'Mleko',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Brasno',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Secer',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'So',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Vegeta',
                'team_id' => 1,
                'user_id' => 1,
            ],[
                'name'    => 'Ubrus',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Toalet papir',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Kafa',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Nescafe',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Voda Balon',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Coca Cola',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Kifle',
                'team_id' => 1,
                'user_id' => 1,
            ],
            [
                'name'    => 'Pivo',
                'team_id' => 1,
                'user_id' => 1,
            ],
        ];

        Item::insert($data);
        Schema::enableForeignKeyConstraints();
    }
}
