<?php

use Illuminate\Database\Seeder;

class WardTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ward_type')->delete();
        $ward_type = [
            [
                'id' => '1',
                'name' => 'Phường',
            ],
            [
                'id' => '2',
                'name' => 'Xã',
            ],
            [
                'id' => '3',
                'name' => 'Thị Trấn',
            ]
        ];
        DB::table('ward_type')->insert($ward_type);
    }
}
