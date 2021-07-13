<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable=['comment'];

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot([
           'total',
           'quantity'
        ]);
    }

    public function ordered()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
