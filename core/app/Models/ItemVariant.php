<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariant extends Model
{
    protected $table = 'item_variants';

    protected $fillable = [
        'item_id',
        'image',
        'stock',
        'price_override',
    ];

    public $timestamps = true;

    // Relationship (no FK enforced, but logical relation)
     public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function values()
    {
        return $this->hasMany(ItemVariantValue::class);
    }
    // public function variantValues()
    // {
    //     return $this->hasMany(ItemVariantValue::class, 'item_variant_id', 'id');
    // }
    
    
}
