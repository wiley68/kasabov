<?php

use Illuminate\Database\Seeder;
use App\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $colors = ['white', 'gray', 'black', 'red', 'yellow', 'green', 'blue', 'brown'];
        $ages = ['child', 'adult', 'any'];
        $pols = ['man', 'woman', 'any'];
        $condition = ['new', 'old'];
        $boolrand = [false, true];
        $availablefor = ['city', 'cities', 'area', 'country'];

        for ($i=1; $i <500; $i++) {
            Product::create([
                'user_id'=>2,
                'category_id'=>rand(1, 22),
                'holiday_id'=>rand(7, 28),
                'product_name'=>'продукт ' . $i,
                'product_code'=>'COD' . $i,
                'first_color'=>$colors[array_rand($colors)],
                'second_color'=>$colors[array_rand($colors)],
                'age'=>$ages[array_rand($ages)],
                'pol'=>$pols[array_rand($pols)],
                'condition'=>$condition[array_rand($condition)],
                'send_id'=>rand(1, 5256),
                'send_from_id'=>rand(1, 5256),
                'price_send'=>Product::frand(0, 100, 2),
                'send_free'=>$boolrand[array_rand($boolrand)],
                'send_free_id'=>rand(1, 5256),
                'available_for'=>$availablefor[array_rand($availablefor)],
                'object'=>$boolrand[array_rand($boolrand)],
                'object_name'=>Product::generateRandomString(30),
                'personalize'=>$boolrand[array_rand($boolrand)],
                'description'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris interdum tempor arcu, eget aliquam nisi ornare non. Maecenas quis dolor aliquam, dignissim odio in, interdum lectus. Vestibulum et eleifend ante, quis posuere nunc. Phasellus vel ipsum molestie, sollicitudin ipsum consectetur, aliquam nisl. Aenean id ultricies neque. Nulla facilisis elementum dolor, at dapibus risus fermentum sed. Etiam condimentum ipsum eu mollis ultrices. Donec ut mi non nulla porta mollis sit amet eu lorem. Nulla facilisi.',
                'quantity'=>rand(1, 30),
                'price'=>Product::frand(0, 5, 2),
                'image'=>''
            ]);
        }
    }

}
