<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category_item extends Model
{
    protected $fillable = [
        'id_item', 'id_category',
    ];
}
