<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_category';
    public $incrementing = false;
    protected $keyType = 'string';

    public function topic()
    {
        return $this->belongsTo('App\Models\Topic', 'topic_id', 'id');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Post', 'category_id', 'id');
    }
}
