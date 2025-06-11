<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductFilter extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'is_active',
        'created_by',
        'store_id'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->slug = Str::slug($model->name);
        });
    }

    public function values()
    {
        return $this->hasMany(ProductFilterValue::class, 'filter_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_filter')
            ->withPivot('filter_value_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
} 