<?php

namespace Database\Seeders;

use App\Models\Category_Product;
use Illuminate\Database\Seeder;

class Category_productSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('name' => 'Hot Coffees','menu' => 'Drinks','url' => 'uploads/menu/item1.png'),
            array('name' => 'Hot Teas','menu' => 'Drinks','url' => 'uploads/menu/item2.png'),
            array('name' => 'Cold coffees','menu' => 'Drinks','url' => 'uploads/menu/item3.png'),
            array('name' => 'Iced Teas','menu' => 'Drinks','url' => 'uploads/menu/item4.png'),
            array('name' => 'Beverges','menu' => 'Drinks','url' => 'uploads/menu/item5.png'),
            array('name' => 'Breakfast','menu' => 'Food','url' => 'uploads/menu/item6.png'),
            array('name' => 'Bakery','menu' => 'Food','url' => 'uploads/menu/item7.png'),
            array('name' => 'Snacks','menu' => 'Food','url' => 'uploads/menu/item8.png'),
            array('name' => 'Savouries','menu' => 'Food','url' => 'uploads/menu/item9.png'),
            array('name' => 'Yagurt','menu' => 'Food','url' => 'uploads/menu/item10.png'),
            array('name' => 'Coffee Beans','menu' => 'DIY','url' => 'uploads/menu/item11.png'),
            array('name' => 'Chocolate Chips','menu' => 'DIY','url' => 'uploads/menu/item12.png'),
            array('name' => 'Nuts','menu' => 'DIY','url' => 'uploads/menu/item13.png')
        );

        foreach($data as $item)
        Category_Product::create($item);
    }
}
