<?php

use Illuminate\Database\Seeder;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('province')->delete();
        $province = [
            [ "id" => '01', "name" => 'Hà Nội', "type_id" => 1 ],
            [ "id" => '02', "name" => 'Hà Giang', "type_id" => 2 ],
            [ "id" => '04', "name" => 'Cao Bằng', "type_id" => 2 ],
            [ "id" => '06', "name" => 'Bắc Kạn', "type_id" => 2 ],
            [ "id" => '08', "name" => 'Tuyên Quang', "type_id" => 2 ],
            [ "id" => '10', "name" => 'Lào Cai', "type_id" => 2 ],
            [ "id" => '11', "name" => 'Điện Biên', "type_id" => 2 ],
            [ "id" => '12', "name" => 'Lai Châu', "type_id" => 2 ],
            [ "id" => '14', "name" => 'Sơn La', "type_id" => 2 ],
            [ "id" => '15', "name" => 'Yên Bái', "type_id" => 2 ],
            [ "id" => '17', "name" => 'Hòa Bình', "type_id" => 2 ],
            [ "id" => '19', "name" => 'Thái Nguyên', "type_id" => 2 ],
            [ "id" => '20', "name" => 'Lạng Sơn', "type_id" => 2 ],
            [ "id" => '22', "name" => 'Quảng Ninh', "type_id" => 2 ],
            [ "id" => '24', "name" => 'Bắc Giang', "type_id" => 2 ],
            [ "id" => '25', "name" => 'Phú Thọ', "type_id" => 2 ],
            [ "id" => '26', "name" => 'Vĩnh Phúc', "type_id" => 2 ],
            [ "id" => '27', "name" => 'Bắc Ninh', "type_id" => 2 ],
            [ "id" => '30', "name" => 'Hải Dương', "type_id" => 2 ],
            [ "id" => '31', "name" => 'Hải Phòng', "type_id" => 1 ],
            [ "id" => '33', "name" => 'Hưng Yên', "type_id" => 2 ],
            [ "id" => '34', "name" => 'Thái Bình', "type_id" => 2 ],
            [ "id" => '35', "name" => 'Hà Nam', "type_id" => 2 ],
            [ "id" => '36', "name" => 'Nam Định', "type_id" => 2 ],
            [ "id" => '37', "name" => 'Ninh Bình', "type_id" => 2 ],
            [ "id" => '38', "name" => 'Thanh Hóa', "type_id" => 2 ],
            [ "id" => '40', "name" => 'Nghệ An', "type_id" => 2 ],
            [ "id" => '42', "name" => 'Hà Tĩnh', "type_id" => 2 ],
            [ "id" => '44', "name" => 'Quảng Bình', "type_id" => 2 ],
            [ "id" => '45', "name" => 'Quảng Trị', "type_id" => 2 ],
            [ "id" => '46', "name" => 'Thừa Thiên Huế', "type_id" => 2 ],
            [ "id" => '48', "name" => 'Đà Nẵng', "type_id" => 1 ],
            [ "id" => '49', "name" => 'Quảng Nam', "type_id" => 2 ],
            [ "id" => '51', "name" => 'Quảng Ngãi', "type_id" => 2 ],
            [ "id" => '52', "name" => 'Bình Định', "type_id" => 2 ],
            [ "id" => '54', "name" => 'Phú Yên', "type_id" => 2 ],
            [ "id" => '56', "name" => 'Khánh Hòa', "type_id" => 2 ],
            [ "id" => '58', "name" => 'Ninh Thuận', "type_id" => 2 ],
            [ "id" => '60', "name" => 'Bình Thuận', "type_id" => 2 ],
            [ "id" => '62', "name" => 'Kon Tum', "type_id" => 2 ],
            [ "id" => '64', "name" => 'Gia Lai', "type_id" => 2 ],
            [ "id" => '66', "name" => 'Đắk Lắk', "type_id" => 2 ],
            [ "id" => '67', "name" => 'Đắk Nông', "type_id" => 2 ],
            [ "id" => '68', "name" => 'Lâm Đồng', "type_id" => 2 ],
            [ "id" => '70', "name" => 'Bình Phước', "type_id" => 2 ],
            [ "id" => '72', "name" => 'Tây Ninh', "type_id" => 2 ],
            [ "id" => '74', "name" => 'Bình Dương', "type_id" => 2 ],
            [ "id" => '75', "name" => 'Đồng Nai', "type_id" => 2 ],
            [ "id" => '77', "name" => 'Bà Rịa - Vũng Tàu', "type_id" => 2 ],
            [ "id" => '79', "name" => 'Hồ Chí Minh', "type_id" => 1 ],
            [ "id" => '80', "name" => 'Long An', "type_id" => 2 ],
            [ "id" => '82', "name" => 'Tiền Giang', "type_id" => 2 ],
            [ "id" => '83', "name" => 'Bến Tre', "type_id" => 2 ],
            [ "id" => '84', "name" => 'Trà Vinh', "type_id" => 2 ],
            [ "id" => '86', "name" => 'Vĩnh Long', "type_id" => 2 ],
            [ "id" => '87', "name" => 'Đồng Tháp', "type_id" => 2 ],
            [ "id" => '89', "name" => 'An Giang', "type_id" => 2 ],
            [ "id" => '91', "name" => 'Kiên Giang', "type_id" => 2 ],
            [ "id" => '92', "name" => 'Cần Thơ', "type_id" => 1 ],
            [ "id" => '93', "name" => 'Hậu Giang', "type_id" => 2 ],
            [ "id" => '94', "name" => 'Sóc Trăng', "type_id" => 2 ],
            [ "id" => '95', "name" => 'Bạc Liêu', "type_id" => 2 ],
            [ "id" => '96', "name" => 'Cà Mau', "type_id" => 2 ],
        ];
        DB::table('province')->insert($province);
    }
}
