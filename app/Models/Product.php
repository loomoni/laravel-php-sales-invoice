<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    static public function getProducts()
    {
        $return = self::select('products.*', 'categories.name as category_name')
                ->join('categories', 'categories.id', '=', 'products.category_id', 'left')
                ->orderBy('products.id', 'desc')
                ->get();
       return $return;
    }
}
