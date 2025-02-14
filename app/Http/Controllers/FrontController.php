<?php

namespace App\Http\Controllers;

use App\Models\PackageTour;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //

    public function index(){
        $package_tours = PackageTour::orderBy('id', 'desc')->take(3)->get();
        return view('front.home', compact('package_tours'));
    }

    public function details(PackageTour $packageTour){
        $latestPhotos = $packageTour->package_photo()->orderBy('id', 'desc')->take(3)->get();
        return view('front.details', compact('packageTour', 'latestPhotos'));
    }

    public function book (PackageTour $packageTour){
        return view('front.book', compact('packageTour'));
    }
}
