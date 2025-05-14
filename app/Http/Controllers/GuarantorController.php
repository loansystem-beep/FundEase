<?php

namespace App\Http\Controllers;

use App\Models\Guarantor;
use App\Models\User;
use Illuminate\Http\Request;

class GuarantorController extends Controller
{
    /**
     * Display a listing of the guarantors.
     */
    public function index()
    {
        $guarantors = Guarantor::latest()->paginate(20);
        return view('guarantors.index', compact('guarantors'));
    }

    /**
     * Show the form for creating a new guarantor.
     */
    public function create()
    {
        $loanOfficers = User::select('id', 'first_name', 'last_name')->get();
        return view('guarantors.create', compact('loanOfficers'));
    }

    /**
     * Store a newly created guarantor in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'country' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:255',
            'middle_last_name' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|digits_between:7,15',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date_format:Y-m-d',
            'photo' => 'nullable|image|max:2048',
            'guarantor_files.*' => 'nullable|file|max:4096',
            'loan_officer_id' => 'nullable|exists:users,id',
        ]);

        // Collect the input data
        $data = $request->all();

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('guarantor_photos', 'public');
        }

        // Create the guarantor
        $guarantor = Guarantor::create($data);

        // Handle file uploads for guarantor files (optional for future functionality)
        if ($request->hasFile('guarantor_files')) {
            // Loop through files and store them (add future media handling if needed)
            foreach ($request->file('guarantor_files') as $file) {
                $guarantor->addMedia($file)->toMediaCollection('guarantor_files');
            }
        }

        return redirect()->route('guarantors.index')->with('success', 'Guarantor created successfully.');
    }

    /**
     * Show the form for editing the specified guarantor.
     */
    public function edit(Guarantor $guarantor)
    {
        $loanOfficers = User::select('id', 'first_name', 'last_name')->get();
        return view('guarantors.edit', compact('guarantor', 'loanOfficers'));
    }

    /**
     * Update the specified guarantor in storage.
     */
    public function update(Request $request, Guarantor $guarantor)
    {
        // Validate the incoming request
        $request->validate([
            'country' => 'required|string|max:100',
            'first_name' => 'nullable|string|max:255',
            'middle_last_name' => 'nullable|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'mobile' => 'nullable|digits_between:7,15',
            'email' => 'nullable|email|max:255',
            'dob' => 'nullable|date_format:Y-m-d',
            'photo' => 'nullable|image|max:2048',
            'guarantor_files.*' => 'nullable|file|max:4096',
            'loan_officer_id' => 'nullable|exists:users,id',
        ]);

        // Collect the input data
        $data = $request->all();

        // Handle photo upload (if provided)
        if ($request->hasFile('photo')) {
            // Delete the old photo (if exists)
            if ($guarantor->photo) {
                \Storage::disk('public')->delete($guarantor->photo);
            }
            $data['photo'] = $request->file('photo')->store('guarantor_photos', 'public');
        }

        // Update the guarantor with the new data
        $guarantor->update($data);

        // Handle file uploads for guarantor files (optional)
        if ($request->hasFile('guarantor_files')) {
            foreach ($request->file('guarantor_files') as $file) {
                $guarantor->addMedia($file)->toMediaCollection('guarantor_files');
            }
        }

        return redirect()->route('guarantors.index')->with('success', 'Guarantor updated successfully.');
    }

    /**
     * Remove the specified guarantor from storage.
     */
    public function destroy(Guarantor $guarantor)
    {
        // Delete associated media (photo and files)
        if ($guarantor->photo) {
            \Storage::disk('public')->delete($guarantor->photo);
        }
        
        // Delete any attached files
        $guarantor->clearMediaCollection('guarantor_files');

        // Delete the guarantor record
        $guarantor->delete();

        return redirect()->route('guarantors.index')->with('success', 'Guarantor deleted successfully.');
    }
}
