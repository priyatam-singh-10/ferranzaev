<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemModel extends Model
{
    use SoftDeletes;

    protected $table = 'item_model';

    protected $fillable = [
        'name',
        'status',
    ];
}
