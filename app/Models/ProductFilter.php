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
            $model->slug = $model->generateUniqueSlug($model->name);
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = $model->generateUniqueSlug($model->name);
            }
        });
    }

    protected function generateUniqueSlug($name)
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 1;

        // Verifica se o slug já existe na mesma loja
        while (static::where('slug', $slug)
                    ->where('store_id', $this->store_id)
                    ->where('id', '!=', $this->id)
                    ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function values()
    {
        return $this->hasMany(ProductFilterValue::class, 'filter_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_filter', 'filter_id', 'product_id')
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