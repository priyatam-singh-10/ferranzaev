<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemVariantValue extends Model
{
    protected $table = 'item_variant_values';

    protected $fillable = [
        'item_variant_id',
        'attribute_id',
        'attribute_option_id',
    ];

    public $timestamps = true;

    public function variant()
    {
        return $this->belongsTo(ItemVariant::class, 'item_variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function option()
    {
        return $this->belongsTo(AttributeOption::class, 'attribute_option_id');
    }
}
