<?php

use Illuminate\Database\Seeder;

class ProvinceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('province_type')->delete();
        $province_type = [
            [
                'id' => '1',
                'name' => 'Thành Phố',
            ],
            [
                'id' => '2',
                'name' => 'Tỉnh',
            ]
        ];
        DB::table('province_type')->insert($province_type);
    }
}
