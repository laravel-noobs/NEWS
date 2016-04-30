<?php

use Illuminate\Database\Seeder;

class DistrictTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('district_type')->delete();
        $district_type = [
            [
                'id' => '1',
                'name' => 'Quận',
            ],
            [
                'id' => '2',
                'name' => 'Thị Xã',
            ],
            [
                'id' => '3',
                'name' => 'Huyện',
            ],
            [
                'id' => '4',
                'name' => 'Thành Phố',
            ]
        ];
        DB::table('district_type')->insert($district_type);
    }
}
