<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'compare_price', 'image', 'status', 'category_id' . 'store_id'];
    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            if (auth()->user() && auth()->user()->store_id) {
                $builder->where('store_id', '=', auth()->user()->store_id);
            }
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class); // (many to many)
    }
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', '=', 'active');
    }


    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fsudbury.legendboats.com%2Fs%2Fserial-number%2Fa2I4z000001xqCOEAY%2F3b256487%3Flanguage%3Den_CA&psig=AOvVaw3bZXOAzgHRRZV2T16Ux8aN&ust=1716819308010000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCKiv3bnAq4YDFQAAAAAdAAAAABAE';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
    public function getSalePercentAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(($this->price / $this->compare_price * 100) - 100, 1);
    }
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
