<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'unit_price', 'qty'];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'item_id');
    }
}