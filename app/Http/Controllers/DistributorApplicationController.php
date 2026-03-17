<?php

namespace App\Http\Controllers;

use App\Models\DistributorApplication;
use Illuminate\Http\Request;

class DistributorApplicationController extends Controller
{
    public function create()
    {
        return view('distributor.apply');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'business_name' => 'nullable|string|max:255',
            'district' => 'required|string|max:120',
            'address' => 'nullable|string|max:1000',
            'experience' => 'nullable|string|max:1000',
            'message' => 'nullable|string|max:1000',
        ]);

        DistributorApplication::create($validated + [
            'status' => 'new',
        ]);

        return redirect()->route('home')->with('success', 'Application submitted successfully. Our team will contact you soon.');
    }
}
