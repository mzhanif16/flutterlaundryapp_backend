<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class promo extends Model
{
    protected $table = 'promo';
    use HasFactory;

    public function shop(){
        return $this->belongsTo(Shop::class);
    }

    protected $fillable = [
        'image',
        'shop_id',
        'old_price',
        'new_price',
        'description',
    ];
}
