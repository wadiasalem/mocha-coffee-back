<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('name' => 'Black Cap','description' => 'Black cap with Mocha-Milk couple image.','quantity' => '80','price' => '12','img' => 'uploads/shop/aa.jpg'),
            array('name' => 'Unisex Bag','description' => 'Milk-Mocha patterned stylish shoulder bag','quantity' => '97','price' => '45','img' => 'uploads/shop/ece.jpg'),
            array('name' => 'Doing Nothing T-Shirt (Pink)','description' => 'Short Sleeve T-shirt, Pink Colored','quantity' => '100','price' => '30','img' => 'uploads/shop/caa.jpg'),
            array('name' => 'Doing Nothing T-Shirt (Black)','description' => 'Short Sleeve T-shirt, Black Colored','quantity' => '97','price' => '30','img' => 'uploads/shop/caca.jpg'),
            array('name' => 'Mouth Mask','description' => 'Black mouth mask with Milk-Mocha prints','quantity' => '300','price' => '5','img' => 'uploads/shop/masks-07762_540x.jpg'),
            array('name' => 'Happy Birthday PostCard','description' => 'a birthday wish card with cute design','quantity' => '500','price' => '2','img' => 'uploads/shop/hb.jpg'),
            array('name' => 'Take a Break NoteBook','description' => 'Take a Break and enjoy some notes with your coffee','quantity' => '100','price' => '15','img' => 'uploads/shop/hr.jpg'),
            array('name' => 'Stickers','description' => 'A 15-sticker set of cute Mocha','quantity' => '100','price' => '2','img' => 'uploads/shop/qt.jpg'),
            array('name' => 'KeyChain','description' => 'Cute practical Keychain with Milk perso','quantity' => '50','price' => '6','img' => 'uploads/shop/vv.jpg')
        );

        foreach($data as $item)
        Gift::create($item);
    }
}
