<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductFilterValue extends Model
{
    protected $fillable = [
        'filter_id',
        'value',
        'slug',
        'color',
        'order'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->value);
        });
    }

    public function filter()
    {
        return $this->belongsTo(ProductFilter::class, 'filter_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_filter', 'filter_value_id', 'product_id');
    }
} 