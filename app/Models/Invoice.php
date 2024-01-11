<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    static public function getInvoices()
    {
        $return = self::select('invoices.*', 'customers.name as customer_name')
                        ->join('customers', 'customers.id', '=', 'invoices.customer_id', 'right')
                        ->orderBy('invoices.id', 'desc')
                        ->get();
        return $return;
    }
}
