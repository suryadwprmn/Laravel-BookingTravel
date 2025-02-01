<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackagePhoto extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['package_tour_id', 'photo'];

    // Define the relationship with the PackageTour model
    public function package_tour()
    {
        return $this->belongsTo(PackageTour::class);
    }
}
