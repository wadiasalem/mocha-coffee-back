<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductesSeed extends Seeder
{
    
    

    public function run()
    {
        $data = array(
            array('name' => 'cream delight espresso','stock' => '149','price' => '10','img' => 'uploads/products/drinks/hotCoffee/creamDelightEspresso.png
                      ','category' => '1'),
            array('name' => 'oreo hot latte','stock' => '92','price' => '7','img' => 'uploads/products/drinks/hotCoffee/oreoHotLatte.png
                      ','category' => '1'),
            array('name' => 'lemon tea mix','stock' => '95','price' => '6','img' => 'uploads/products/drinks/hotTea/lemonTeaMix.png
                      ','category' => '2'),
            array('name' => 'thai pumpkin press','stock' => '88','price' => '6','img' => 'uploads/products/drinks/coldTea/thaiPumpkinPress.png
                      ','category' => '4'),
            array('name' => 'vanilla cappucino','stock' => '96','price' => '8','img' => 'uploads/products/drinks/coldCoffee/vanillaCappucino.png
                      ','category' => '3'),
            array('name' => 'soda','stock' => '98','price' => '5','img' => 'uploads/products/drinks/beverages/soda.png
                      ','category' => '5'),
            array('name' => 'Americano Oreo Cake','stock' => '98','price' => '12','img' => 'uploads/products/food/bakery/AmericanOreoCake.png
                      ','category' => '7'),
            array('name' => 'Pumpkin Roll (Halloween Special) ','stock' => '98','price' => '14','img' => 'uploads/products/food/bakery/pumpkinRoll.png
                      ','category' => '7'),
            array('name' => 'Unicorn Cake','stock' => '98','price' => '14','img' => 'uploads/products/food/bakery/UnicornCake.png
                      ','category' => '7'),
            array('name' => 'Dark Chocolat Pie','stock' => '100','price' => '6','img' => 'uploads/products/food/breakfast/darkChocolatPie.png
                      ','category' => '6'),
            array('name' => 'Marshmallow Pie','stock' => '100','price' => '7','img' => 'uploads/products/food/breakfast/marshmallowPie.png
                      ','category' => '6'),
            array('name' => 'Roasted Chicken (150g serving)','stock' => '100','price' => '16','img' => 'uploads/products/food/savoury/roastedChicken.png
                      ','category' => '9'),
            array('name' => 'Animals Ice Cream','stock' => '99','price' => '3','img' => 'uploads/products/food/snacks/iceCream.png
                      ','category' => '8'),
            array('name' => 'Ice Cream','stock' => '99','price' => '4','img' => 'uploads/products/food/snacks/iceCreamAnimals.png
                      ','category' => '8'),
            array('name' => 'Frozen Greek Yogurt','stock' => '100','price' => '21','img' => 'uploads/products/food/yagurt/frozenGreekYogurt.png
                      ','category' => '10'),
            array('name' => 'Chocolat Fudge Frozen Yogurt','stock' => '100','price' => '8','img' => 'uploads/products/food/yagurt/frenchFrozenYogurt.png
                      ','category' => '10'),
            array('name' => 'Ground Beans','stock' => '100','price' => '14','img' => 'uploads/products/diy/coffeBeans/groundBeans.png
                      ','category' => '11'),
            array('name' => 'Whole Beans','stock' => '100','price' => '12','img' => 'uploads/products/diy/coffeBeans/wholeBeans.png
                      ','category' => '11'),
            array('name' => 'Hazelnuts','stock' => '100','price' => '25','img' => 'uploads/products/diy/nuts/hazelnuts.png
                      ','category' => '13'),
            array('name' => 'Chocolat Chips','stock' => '100','price' => '4','img' => 'uploads/products/diy/chocholat/chocolatChips.png
                      ','category' => '12'),
            array('name' => 'Chocolat Mix Box','stock' => '100','price' => '41','img' => 'uploads/products/diy/chocholat/chocolatMixBox.png
                      ','category' => '12')
          );

        foreach($data as $item)
        Product::create($item);

    }
}
