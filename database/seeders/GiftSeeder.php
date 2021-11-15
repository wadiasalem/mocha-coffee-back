<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Black Cap','description'=>'Black cap with Mocha-Milk couple image.','quantity'=>'50','price'=>'15','img'=>'http://127.0.0.1:8000/uploads/shop/aa.jpg'] ,
            ['name' => 'Unisex Bag','description'=>'Milk-Mocha patterned stylish shoulder bag','quantity'=>'100','price'=>'45','img'=>'http://127.0.0.1:8000/uploads/shop/ece.jpg'] ,
            ['name' => 'Doing Nothing T-Shirt (Pink)','description'=>'Short Sleeve T-shirt, Pink Colored','quantity'=>'100','price'=>'30','img'=>'http://127.0.0.1:8000/uploads/shop/caa.jpg'] ,
            ['name' => 'Doing Nothing T-Shirt (Black)','description'=>'Short Sleeve T-shirt, Black Colored','quantity'=>'100','price'=>'30','img'=>'http://127.0.0.1:8000/uploads/shop/caca.jpg'] ,  
            ['name' => 'Mouth Mask','description'=>'Black mouth mask with Milk-Mocha prints','quantity'=>'300','price'=>'5','img'=>'http://127.0.0.1:8000/uploads/shop/masks-07762_540x.jpg'] ,
            ['name' => 'Happy Birthday PostCard','description'=>'a birthday wish card with cute design','quantity'=>'500','price'=>'2','img'=>'http://127.0.0.1:8000/uploads/shop/hb.jpg'] ,
            ['name' => 'Take a Break NoteBook','description'=>'Take a Break and enjoy some notes with your coffee','quantity'=>'100','price'=>'15','img'=>'http://127.0.0.1:8000/uploads/shop/hr.jpg'] ,
            ['name' => 'Stickers','description'=>'A 15-sticker set of cute Mocha','quantity'=>'100','price'=>'2','img'=>'http://127.0.0.1:8000/uploads/shop/qt.jpg'] , 
            ['name' => 'KeyChain','description'=>'Cute practical Keychain with Milk perso','quantity'=>'50','price'=>'6','img'=>'http://127.0.0.1:8000/uploads/shop/vv.jpg'] , 
        ];

        foreach($data as $item)
        Gift::create($item);
    }
}