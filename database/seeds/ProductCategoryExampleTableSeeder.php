<?php

use Illuminate\Database\Seeder;

class ProductCategoryExampleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_category')->delete();

        $thuoc_bo = DB::table('product_category')->insertGetId([
            'name' => 'Thuốc bổ',
            'slug' => str_slug('Thuốc bổ'),
            'description' => "Các loại thuốc bổ tim, não, gan mật, tuần hoàn"
        ]);
        $thuoc_tranh_thai = DB::table('product_category')->insertGetId([
            'name' => 'Thuốc tránh thai',
            'slug' => str_slug('Thuốc tránh thai'),
            'description' => 'Các loại thuốc tránh thai cho nam nữ'
        ]);

        $categories = [
            [
                'name' => 'Thuốc trị gun',
                'slug' => str_slug('Thuốc trị gun'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => null
            ],
            [
                'name' => 'Thuốc chống nhục',
                'slug' => str_slug('Thuốc chống nhục'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. ",
                'parent_id' => null
            ],
            [
                'name' => 'Thuốc tránh thai nam',
                'slug' => str_slug('Thuốc tránh thai nam'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $thuoc_tranh_thai
            ],
            [
                'name' => 'Thuốc tránh thai nữ',
                'slug' => str_slug('Thuốc tránh thai nữ'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $thuoc_tranh_thai
            ],
            [
                'name' => 'Bổ phèo',
                'slug' => str_slug('Bổ phèo'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $thuoc_bo
            ],
            [
                'name' => 'Bổ móng tay',
                'slug' => str_slug('Bổ móng tay'),
                'description' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry.",
                'parent_id' => $thuoc_bo
            ],
        ];
        DB::table('product_category')->insert($categories);
    }
}
