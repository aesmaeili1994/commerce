<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory, sluggable;

    protected $table="products";
    protected $guarded=[];
    protected $appends=['quantity_check','sale_check','price_check'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class,'product_tag');
    }

//    query for attributes & variation &sort
    public function scopeFilter($query)
    {

//        query for attributes
        if (request()->has('attribute')) {
            foreach (request()->attribute as $attribute){
                $query->whereHas('attributes',function ($query) use($attribute){
                    foreach (explode('-',$attribute) as $index => $value){
                        if ($index == 0) {
                            $query->where('value',$value);
                        }else{
                            $query->orWhere('value',$value);
                        }
                    }
                });
            }
        }

//        query for variations
        if (request()->has('variation')) {
            $query->whereHas('variations', function ($query) {
                foreach (explode('-', request()->variation) as $index => $variation){
                    if ($index == 0) {
                        $query->where('value',$variation);
                    }else{
                        $query->orWhere('value',$variation);
                    }
                }
            });
        }

//        query for sort
        if(request()->has('sortBy')){
            $sortBy=request()->sortBy;

            switch ($sortBy) {
                case 'max':
                    $query->orderByDesc(
                        ProductVariation::select('price')->whereColumn('product_variations.product_id','products.id')->orderBy('price','desc')->take(1)
                    );
                    break;

                case 'min':
                    $query->orderBy(
                        ProductVariation::select('price')->whereColumn('product_variations.product_id','products.id')->orderBy('price')->take(1)
                    );
                    break;

                case 'latest':
                    $query->latest();
                    break;

                case 'oldest':
                    $query->oldest();
                    break;

                default:
                    $query;
                    break;
            }
        }

        return $query;
    }

//    query for search
    public function scopeSearch($query)
    {

//        query for search
        if (request()->has('search') && trim(request()->search) != '') {
            $keyword=request()->search;
            $query->where('name','LIKE','%'.trim($keyword).'%');
        }

        return $query;
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    //if this is products return one product else return '0'
    public function getQuantityCheckAttribute()
    {
        return $this->variations()->where('quantity','>',0)->first() ??  0;
    }

    //if sale is -> return the most sale variation for product else return 'false'
    public function getSaleCheckAttribute()
    {
        return $this->variations()->
            where('quantity','>',0)->
            where('sale_price','!=',null)->
            where('date_on_sale_from','<',Carbon::now())->
            where('date_on_sale_to','>',Carbon::now())->
            orderBy('sale_price')->first() ?? false;
    }

    //return the latest price of variations of product
    public function getPriceCheckAttribute()
    {
        return $this->variations()->where('quantity','>',0)->orderBy('price')->first() ??  false;
    }

    public function getIsActiveAttribute($is_active)
    {
        return $is_active ? 'فعال' : 'غیرفعال' ;
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductVariation::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(Comment::class)->where('approved',1);
    }

    public function checkUserWishlist($userId)
    {
        return $this->hasMany(Wishlist::class)->where('user_id',$userId)->exists();
    }

}
