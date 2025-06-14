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
            $model->slug = $model->generateUniqueSlug($model->value);
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('value')) {
                $model->slug = $model->generateUniqueSlug($model->value);
            }
        });
    }

    protected function generateUniqueSlug($value)
    {
        $baseSlug = Str::slug($value);
        $slug = $baseSlug;
        $counter = 1;

        // Verifica se o slug já existe globalmente (todos os filter values)
        while (static::where('slug', $slug)
                    ->where('id', '!=', $this->id)
                    ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
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