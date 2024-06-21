<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{

    public function scopeFillter($query, array $filters)
    {
        if (request('status') ?? false) {
            $query->where('status', '=', request('status'));
        }
        if (request('name') ?? false) {
            $query->where('name', 'like', '%' . request('name') . '%');
        }
    }
    protected $fillable = ['name', 'parent_id', 'description', 'image', 'status', 'slug'];
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    use HasFactory, SoftDeletes;
    public static function rules($id = 0)
    {
        return
            [
                'name' => [
                    "required",
                    'string',
                    'min:3',
                    'max:255',
                    Rule::unique('Categories', 'name')->ignore($id),

                    //     function($attribute,$value,$fails){
                    //         if( strtolower($value)=='laravel')
                    //         return  $fails('this name is forbidden');

                    // },
                    new Filter([
                        'laravel', 'php'
                    ])

                ],
                'parent_id' => 'nullable|int|exists:Categories,id|',
                'image' => 'image|max:1048576|dimensions:min_width=100,min_height=100:', //size of image 1048576
                'status' => Rule::in(['active', 'inactive']),
            ];
    }
}
