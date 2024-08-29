<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'product_name',
        'price',
        'stock',
        'maker_id',
        'detail',
        'user_id',
        ];

        public function maker()
        {
            return $this->belongsTo(Maker::class, 'maker_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class, 'user_id');
        }
}
