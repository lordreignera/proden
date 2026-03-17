<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DistributorApplication;
use Illuminate\Http\Request;

class DistributorApplicationAdminController extends Controller
{
    public function index()
    {
        $applications = DistributorApplication::latest()->paginate(20);
        return view('admin.distributors', compact('applications'));
    }

    public function updateStatus(Request $request, DistributorApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:new,contacted,approved,rejected',
        ]);

        $application->status = $validated['status'];
        if ($validated['status'] === 'contacted' && !$application->contacted_at) {
            $application->contacted_at = now();
        }
        $application->save();

        return redirect()->back()->with('success', 'Distributor application status updated.');
    }
}
