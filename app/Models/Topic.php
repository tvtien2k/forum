<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'tbl_topic';
    public $incrementing = false;
    protected $keyType = 'string';

    public function mod()
    {
        return $this->belongsTo('App\Models\User', 'mod_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany('App\Models\Category', 'topic_id', 'id');
    }
}
