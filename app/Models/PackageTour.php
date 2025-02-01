<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageTour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'location',
        'price',
        'days',
        'category_id',
    ];

    public function package_photo(){
        return $this->hasMany(PackagePhoto::class);
    }

    public function package_booking(){
        return $this->hasMany(PackageBooking::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
