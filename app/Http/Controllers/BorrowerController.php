<?php

namespace App\Http\Controllers;

use App\Models\Borrower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowerController extends Controller
{
    // Show the list of borrowers with pagination and filtering options
    public function index(Request $request)
    {
        $borrowersQuery = Borrower::where('user_id', Auth::id())->with(['loans.repayments']);

        // Apply search filter
        if ($request->has('search') && !empty(trim($request->search))) {
            $search = trim($request->search);
            $borrowersQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        // Paginate the borrowers
        $borrowers = $borrowersQuery->paginate(10);

        return view('borrowers.index', compact('borrowers'));
    }

    // Show the form to create a new borrower
    public function create()
    {
        return view('borrowers.create');
    }

    // Store a new borrower
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'borrower_type' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'nullable|email|unique:borrowers,email,NULL,id,user_id,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|string',
            'description' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255', // Location fields
            'country' => 'nullable|string|max:255', // Location fields
            'postal_code' => 'nullable|string|max:255', // Location fields
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the borrower and associate the current user
        Borrower::create(array_merge($request->all(), ['user_id' => Auth::id()]));

        return redirect()->route('borrowers.index')->with('success', 'Borrower added successfully!');
    }

    // Show details of a single borrower
    public function show($id)
    {
        // Fetch the borrower by ID, ensuring it's associated with the current user
        $borrower = Borrower::where('user_id', Auth::id())->findOrFail($id);

        return view('borrowers.show', compact('borrower'));
    }

    // Show the form to edit an existing borrower
    public function edit($id)
    {
        // Fetch the borrower by ID, ensuring it's associated with the current user
        $borrower = Borrower::where('user_id', Auth::id())->findOrFail($id);

        // Return the edit view with the borrower data
        return view('borrowers.edit', compact('borrower'));
    }

    // Update an existing borrower
    public function update(Request $request, Borrower $borrower)
    {
        // Ensure the borrower belongs to the logged-in user
        if ($borrower->user_id !== Auth::id()) {
            return redirect()->route('borrowers.index')->with('error', 'Unauthorized access.');
        }

        // Validate the updated data
        $request->validate([
            'borrower_type' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'business_name' => 'nullable|string|max:255',
            'date_of_birth' => 'required|date',
            'email' => 'nullable|email|unique:borrowers,email,' . $borrower->id . ',id,user_id,' . Auth::id(),
            'phone_number' => 'required|string|max:20',
            'gender' => 'required|string',
            'description' => 'nullable|string',
            'title' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255', // Location fields
            'country' => 'nullable|string|max:255', // Location fields
            'postal_code' => 'nullable|string|max:255', // Location fields
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the borrower details
        $borrower->update($request->all());

        return redirect()->route('borrowers.index')->with('success', 'Borrower updated successfully!');
    }

    // Destroy a borrower record
    public function destroy($id)
    {
        // Fetch the borrower by ID, ensuring it's associated with the current user
        $borrower = Borrower::where('user_id', Auth::id())->findOrFail($id);

        // Delete the borrower
        $borrower->delete();

        // Redirect to borrowers index with a success message
        return redirect()->route('borrowers.index')->with('success', 'Borrower deleted successfully!');
    }
}