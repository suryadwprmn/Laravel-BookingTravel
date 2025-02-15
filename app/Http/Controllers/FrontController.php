<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageBookingCheckoutRequest;
use App\Http\Requests\StorePackageBookingRequest;
use App\Http\Requests\UpdatePackageBookingRequest;
use App\Models\PackageBank;
use App\Models\PackageBooking;
use App\Models\PackageTour;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function book_store(StorePackageBookingRequest $request, PackageTour $packageTour){
        //mengambil data user yang sedang login
        $user = Auth::user();
        //mengambil data bank yang ada
        $bank = PackageBank::orderBy('id', 'desc')->first();
        $packageBookingId = null;

        //membuat transaksi booking
        DB::transaction(function () use ($request, $packageTour, $user, $bank, &$packageBookingId){
            $validated = $request->validated();

            $startDate = new Carbon($validated['start_date']);
            $totalDays = $packageTour->days - 1; // Karena hari pertama sudah dihitung

            $endDate = $startDate->addDays($totalDays);

            $sub_total = $packageTour->price * $validated['quantity'];
            $insurance = 300000 * $validated['quantity'];
            $tax = $sub_total * 0.10;

            $validated['user_id'] = $user->id;
            $validated['package_tour_id'] = $packageTour->id;
            $validated['end_date'] = $endDate;
            $validated['is_paid'] = false;
            $validated['proof'] = 'dummytrx.png';
            $validated['package_bank_id'] = $bank->id;
            $validated['insurance'] = $insurance;
            $validated['tax'] = $tax;
            $validated['sub_total'] = $sub_total;
            $validated['total_amount'] = $sub_total + $insurance + $tax;

            $packageBooking = PackageBooking::create($validated);
            $packageBookingId = $packageBooking->id;
        });

        if($packageBookingId){
            return redirect()->route('front.choose_bank', $packageBookingId);
        } else {
            return back() -> withErrors(['Failed to book package. Please try again later']);
        }
    }

    public function choose_bank(PackageBooking $packageBooking) {
        $banks = PackageBank::all();

        //validasi user apakah sudah login atau belum
        $user = Auth::user();
        if($packageBooking->user_id != $user ->id) {
            return abort(403);
        }

        return view('front.bank', compact('packageBooking', 'banks'));
    }

    public function choose_bank_store(UpdatePackageBookingRequest $request, PackageBooking $packageBooking){
        //validasi user apakah sudah login atau belum
        $user = Auth::user();
        if($packageBooking->user_id != $user ->id) {
            return abort(403);
        }
        DB::transaction(function () use ($request, $packageBooking){
            $validated = $request->validated();
            $packageBooking -> update([
                'package_bank_id' => $validated['package_bank_id']
            ]);
        });
        return redirect()-> route('front.book_payment', $packageBooking->id);
    }

    public function book_payment(PackageBooking $packageBooking){
        return view('front.book_payment', compact('packageBooking'));
    }

    public function book_payment_store(StorePackageBookingCheckoutRequest $request, PackageBooking $packageBooking){
         //validasi user apakah sudah login atau belum
         $user = Auth::user();
         if($packageBooking->user_id != $user ->id) {
             return abort(403);
         }
         DB::transaction(function () use ($request, $user, $packageBooking){
            $validated = $request->validated();
            if($request->hasFile('proof')){
                $validated['proof'] = $request->file('proof')->store('assets/bukti-bayar', 'public');
            }
            $packageBooking -> update($validated);
         });
        return redirect()-> route('front.book_finish');
    }

    public function book_finish(){
        return view('front.finish');
    }
}
