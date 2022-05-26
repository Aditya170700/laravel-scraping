<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function website()
    {
        return $this->belongsTo(Website::class);
    }
    public function item_schema()
    {
        return $this->belongsTo(ItemSchema::class);
    }
}
