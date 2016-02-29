<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RoleTableSeeder::class);
        $this->call(PermissionTableSeeder::class);
        $this->call(RolePermissionTableSeeder::class);
        $this->call(UserExampleTableSeeder::class);

        $this->call(CategoryTableSeeder::class);
        $this->call(PostStatusTableSeeder::class);
        $this->call(CommentStatusTableSeeder::class);
        $this->call(TagExampleTableSeeder::class);

        $this->call(PostExampleTableSeeder::class);

        $this->call(ProductStatusTableSeeder::class);
        $this->call(ProductBrandExampleTableSeeder::class);
        $this->call(ProductCategoryExampleTableSeeder::class);
        $this->call(ProductExampleTableSeeder::class);
        $this->call(ProductReviewExampleTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(OrderExampleTableSeeder::class);
        $this->call(FeedbackExampleSeeder::class);
        $this->call(CommentExampleSeeder::class);
        $this->call(UserRateExampleTableSeeder::class);
        $this->call(OrderProductExampleTableSeeder::class);
        $this->call(TaggableExampleSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Model::reguard();
    }
}
