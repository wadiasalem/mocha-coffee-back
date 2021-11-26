<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductesSeed extends Seeder
{
    
    

    public function run()
    {
        $data = [
            ['name' => 'cream delight espresso','stock'=>'100','price'=>'7','img'=>'http://127.0.0.1:8000/uploads/products/drinks/hotCoffee/creamDelightEspresso.png
            ','category'=>'1'],
            ['name' => 'oreo hot latte','stock'=>'100','price'=>'7','img'=>'http://127.0.0.1:8000/uploads/products/drinks/hotCoffee/oreoHotLatte.png
            ','category'=>'1'],
            ['name' => 'lemon tea mix','stock'=>'100','price'=>'6','img'=>'http://127.0.0.1:8000/uploads/products/drinks/hotTea/lemonTeaMix.png
            ','category'=>'2'],
            ['name' => 'thai pumpkin press','stock'=>'100','price'=>'6','img'=>'http://127.0.0.1:8000/uploads/products/drinks/coldTea/thaiPumpkinPress.png
            ','category'=>'4'],
            ['name' => 'vanilla cappucino','stock'=>'100','price'=>'8','img'=>'http://127.0.0.1:8000/uploads/products/drinks/coldCoffee/vanillaCappucino.png
            ','category'=>'3'],
            ['name' => 'soda','stock'=>'100','price'=>'5','img'=>'http://127.0.0.1:8000/uploads/products/drinks/beverages/soda.png
            ','category'=>'5'],
            ['name' => 'Americano Oreo Cake','stock'=>'100','price'=>'12','img'=>'http://127.0.0.1:8000/uploads/products/food/bakery/AmericanOreoCake.png
            ','category'=>'7'],
            ['name' => 'Pumpkin Roll (Halloween Special) ','stock'=>'100','price'=>'14','img'=>'http://127.0.0.1:8000/uploads/products/food/bakery/pumpkinRoll.png
            ','category'=>'7'],
            ['name' => 'Unicorn Cake','stock'=>'100','price'=>'14','img'=>'http://127.0.0.1:8000/uploads/products/food/bakery/UnicornCake.png
            ','category'=>'7'],
            ['name' => 'Dark Chocolat Pie','stock'=>'100','price'=>'6','img'=>'http://127.0.0.1:8000/uploads/products/food/breakfast/darkChocolatPie.png
            ','category'=>'6'],
            ['name' => 'Marshmallow Pie','stock'=>'100','price'=>'7','img'=>'http://127.0.0.1:8000/uploads/products/food/breakfast/marshmallowPie.png
            ','category'=>'6'],
            ['name' => 'Roasted Chicken (150g serving)','stock'=>'100','price'=>'16','img'=>'http://127.0.0.1:8000/uploads/products/food/savoury/roastedChicken.png
            ','category'=>'9'],
            ['name' => 'Animals Ice Cream','stock'=>'100','price'=>'3','img'=>'http://127.0.0.1:8000/uploads/products/food/snacks/iceCream.png
            ','category'=>'8'],
            ['name' => 'Ice Cream','stock'=>'100','price'=>'4','img'=>'http://127.0.0.1:8000/uploads/products/food/snacks/iceCreamAnimals.png
            ','category'=>'8'],
            ['name' => 'Frozen Greek Yogurt','stock'=>'100','price'=>'21','img'=>'http://127.0.0.1:8000/uploads/products/food/yagurt/frozenGreekYogurt.png
            ','category'=>'10'],
            ['name' => 'Chocolat Fudge Frozen Yogurt','stock'=>'100','price'=>'8','img'=>'http://127.0.0.1:8000/uploads/products/food/yagurt/frenchFrozenYogurt.png
            ','category'=>'10'],
            ['name' => 'Ground Beans','stock'=>'100','price'=>'14','img'=>'http://127.0.0.1:8000/uploads/products/diy/coffeBeans/groundBeans.png
            ','category'=>'11'],
            ['name' => 'Whole Beans','stock'=>'100','price'=>'12','img'=>'http://127.0.0.1:8000/uploads/products/diy/coffeBeans/wholeBeans.png
            ','category'=>'11'],
            ['name' => 'Hazelnuts','stock'=>'100','price'=>'25','img'=>'http://127.0.0.1:8000/uploads/products/diy/nuts/hazelnuts.png
            ','category'=>'13'],
            ['name' => 'Chocolat Chips','stock'=>'100','price'=>'4','img'=>'http://127.0.0.1:8000/uploads/products/diy/chocholat/chocolatChips.png
            ','category'=>'12'],
            ['name' => 'Chocolat Mix Box','stock'=>'100','price'=>'41','img'=>'http://127.0.0.1:8000/uploads/products/diy/chocholat/chocolatMixBox.png
            ','category'=>'12'],

            
        ];

        foreach($data as $item)
        Product::create($item);

    }
}
