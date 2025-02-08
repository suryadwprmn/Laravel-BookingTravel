<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageTourRequest;
use App\Http\Requests\UpdatePackageTourRequest;
use App\Models\Category;
use App\Models\PackageTour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PackageTourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $tours = PackageTour::orderBy('id', 'desc')->paginate(10);
        return view('admin.package_tours.index', compact('tours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = Category::orderBy('id')->get();
        return view('admin.package_tours.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageTourRequest $request)
    {
        //
        DB::transaction(function () use ($request){
            $validatedDataTours = $request->validated();
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/' . date('Y/m/d'), 'public'); //dikanakan date('Y/m/d')
                $validatedDataTours['thumbnail'] = $thumbnailPath;
            }
            $validatedDataTours['slug'] = Str::slug($validatedDataTours['name']);
            $newTour = PackageTour::create($validatedDataTours);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('package_photos/' . date('Y/m/d'), 'public');
                    //Dia akan membuat record baru di table package_photos
                    $newTour->package_photo()->create([
                        'photo' => $photoPath
                    ]);
                }
            }
        });
        return redirect()->route('admin.package_tours.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageTour $packageTour)
    {
        //menampilkan 3 foto terbaru
        $latestPhotos = $packageTour->package_photo()->orderBy('id', 'desc')->take(3)->get();
        return view('admin.package_tours.show', compact('packageTour', 'latestPhotos'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageTour $packageTour)
    {
        //
            $categories = Category::orderBy('id')->get();
            //menampilkan 3 foto terbaru
            $latestPhotos = $packageTour->package_photo()->orderBy('id', 'desc')->take(3)->get();
            return view('admin.package_tours.edit', compact('packageTour', 'latestPhotos', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageTourRequest $request, PackageTour $packageTour)
    {
        DB::transaction(function () use ($request, $packageTour){
            $validatedDataTours = $request->validated();
            if ($request->hasFile('thumbnail')) {
                $thumbnailPath = $request->file('thumbnail')->store('thumbnails/' . date('Y/m/d'), 'public'); //dikanakan date('Y/m/d')
                $validatedDataTours['thumbnail'] = $thumbnailPath;
            }
            $validatedDataTours['slug'] = Str::slug($validatedDataTours['name']);
            $packageTour->update($validatedDataTours);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPath = $photo->store('package_photos/' . date('Y/m/d'), 'public');
                    //Dia akan membuat record baru di table package_photos
                    $packageTour->package_photo()->create([
                        'photo' => $photoPath
                    ]);
                    
                }
            }
        });
        return redirect()->route('admin.package_tours.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageTour $packageTour)
    {
        //
        DB::transaction(function () use ($packageTour){
            $packageTour->delete();
        });
        return redirect()->route('admin.package_tours.index');
    }
}
