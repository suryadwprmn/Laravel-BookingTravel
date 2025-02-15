<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageBooking extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'package_tour_id',
        'user_id',
        'quantity',
        'start_date',
        'end_date',
        'total_amount',
        'is_paid',
        'proof',
        'package_bank_id',
        'sub_total',
        'insurance',
        'tax',
    ];

    //Ketika kita ingin mengubah tipe data dari kolom tertentu, kita bisa menggunakan property $casts. Property ini berfungsi untuk mengubah tipe data dari kolom tertentu. Pada model PackageBooking, kita akan mengubah tipe data dari kolom start_date dan end_date menjadi date.
    //Khusus untuk tanggal
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package_tour()
    {
        return $this->belongsTo(PackageTour::class);
    }

    public function package_bank()
    {
        return $this->belongsTo(PackageBank::class);
    }
}
