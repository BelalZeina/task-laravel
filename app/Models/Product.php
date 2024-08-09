<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'owner_type',
        'owner_id',
        'name',
        'img',
        'description',
        "images",
        'price',
        'stock',
        "discount_percentage",
        "fixed_discount",
        "price_after_discount",
        'is_active'
    ];

    public function categories()
    {
        return $this->belongsToMany(CategoryProduct::class, 'category_product_poducts');
    }
    public function owner()
    {
        return $this->morphTo();
    }


    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    public function attributeValues()
    {
        return $this->hasManyThrough(ProductAttributeValue::class, Attribute::class);
    }


    public function applyPromoCode(PromoCode $promoCode)
    {
        $currentTime = Carbon::now();
        // $currentTime = Carbon::parse($this->start_date);

        // Check if the promo code is active and within the valid date range
        if (!$promoCode->is_active || $currentTime->lt($promoCode->start_date) || $currentTime->gt($promoCode->end_date)) {
            return false;
        }

        // Check if the promo code's applicable scope is for bookings
        if ($promoCode->applicable_scope !== 'product') {
            return false;
        }

        // if ($promoCode->owner_id != $this->club_id || $promoCode->owner_type != get_class($this->club)) {
        //     return false;
        // }

        // Check if the category_id matches
        if ($promoCode->category_id && $this->category_id != $promoCode->category_id) {
            return false;
        }

        // Check if the type_category_id matches
        if ($promoCode->type_category_id && $this->type_category_id != $promoCode->type_category_id) {
            return false;
        }

        // // Check if the booking time is within the promo code's valid time range
        // if (($promoCode->start_time && Carbon::parse($this->start_time) < Carbon::parse($promoCode->start_time)) ||
        //     ($promoCode->end_time && Carbon::parse($this->end_time) > Carbon::parse($promoCode->end_time))) {
        //     return false;
        // }

        // Check if the booking date matches the promo code's valid date
        if ($promoCode->start_date && $promoCode->end_date &&
            ($this->booking_date < $promoCode->start_date || $this->booking_date > $promoCode->end_date)) {
            return false;
        }

        // Apply the discount
        if ($promoCode->type === 'percentage') {
            $this->price -= ($this->price * ($promoCode->value / 100));
        } else if ($promoCode->type === 'fixed') {
            $this->price -= $promoCode->value;
        }

        // Ensure the price does not go below zero
        $this->price = max(0, $this->price);

        return true;
    }
}
