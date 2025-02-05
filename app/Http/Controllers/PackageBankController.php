<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePackageBankRequest;
use App\Http\Requests\UpdatePackageBankRequest;
use App\Models\PackageBank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageBankController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('can:manage package banks');
    
    }
    public function index()
    {
        //
        $banks = PackageBank::orderBy('id', 'desc')->paginate(10);
        return view('admin.banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePackageBankRequest $request)
    {
        //
        DB::transaction(function () use ($request){
            $validatedDataBanks = $request->validated();
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $validatedDataBanks['logo'] = $logoPath;
            }
            $newBank = PackageBank::create($validatedDataBanks);
        });

        return redirect()->route('admin.package_banks.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PackageBank $packageBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PackageBank $packageBank)
    {
        //
        return view('admin.banks.edit', compact('packageBank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePackageBankRequest $request, PackageBank $packageBank)
    {
        //
        DB::transaction(function () use ($request, $packageBank){
            $data = $request->all();
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('logos', 'public');
                $data['logo'] = $logoPath;
            }
            $packageBank->update($data);
        });
        return redirect()->route('admin.package_banks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PackageBank $packageBank)
    {
        //
        DB::transaction(function () use ($packageBank){
            $packageBank->delete();
        });

        return redirect()->route('admin.package_banks.index');
    }
}
