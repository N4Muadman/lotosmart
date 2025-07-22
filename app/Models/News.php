<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\NewCategory;

class News extends Model
{
    protected $fillable = [
        'title', 'slug', 'summary', 'content', 'image', 'category_id', 'status'
    ];
    public function category() {
        return $this->belongsTo(NewCategory::class, 'category_id');
    }


}
