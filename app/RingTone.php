<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class RingTone extends Model
{
    protected $guarded = [];

    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
