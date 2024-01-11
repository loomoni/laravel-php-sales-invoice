<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    static public function getSales()
    {
        $return = self::select('sales.*', 'products.name as product_name')
        ->join('products', 'products.id', '=', 'sales.product_id', 'left')
        ->orderBy('sales.id', 'desc')
        ->get();
return $return;
    }
}
