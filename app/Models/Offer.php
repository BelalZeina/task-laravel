<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'type',
        'value',
        'img',
        'category_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'club_id',
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
