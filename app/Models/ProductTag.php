<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'color',
        'icon',
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

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_tag');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeTag($query)
    {
        return $query->where('type', 'tag');
    }

    public function scopeSeal($query)
    {
        return $query->where('type', 'seal');
    }
} 