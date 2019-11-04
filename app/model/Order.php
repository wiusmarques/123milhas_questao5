<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    
    public function addItem($item_id){
        DB::table('order_item')->insert(
            [
                'item_id' => $item_id, 
                'order_id' => $this->id,
                'created_at' => date('Y-m-d h:m:s'),
                'updated_at' => date('Y-m-d h:m:s')
            ]
        );
    }

    public function removeItem($item_id){
        DB::table('order_item')->where('item_id', $item_id, 'order_id', $this->id)->delete();
    }
}
