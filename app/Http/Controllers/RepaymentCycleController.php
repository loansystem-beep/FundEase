<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RepaymentCycle;

class RepaymentCycleController extends Controller
{
    // Show all repayment cycles with optional search functionality
    public function index(Request $request)
    {
        // Get the search query from the request
        $query = $request->input('search', '');

        // Filter repayment cycles based on the search query and paginate results
        $repaymentCycles = RepaymentCycle::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('name', 'like', '%' . $query . '%')
                ->orWhere('type', 'like', '%' . $query . '%');
        })->paginate(10); // Add pagination here

        // Return the view with repayment cycles and search query
        return view('repayment_cycles.index', compact('repaymentCycles', 'query'));
    }

    // Show form to create a new repayment cycle
    public function create()
    {
        return view('repayment_cycles.create');
    }

    // Store a new repayment cycle
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:days,monthly,weekly',
            'every_x_days' => 'required_if:type,days|nullable|integer|min:1',
            'monthly_dates' => 'required_if:type,monthly|nullable|array',
            'monthly_dates.*' => 'integer|between:1,31',
            'weekly_days' => 'required_if:type,weekly|nullable|array',
            'weekly_days.*' => 'integer|between:1,7',
        ]);

        $repaymentCycle = new RepaymentCycle([
            'name' => $request->name,
            'type' => $request->type,
            'every_x_days' => $request->type === 'days' ? $request->every_x_days : null,
            'fixed_monthly_dates' => $request->type === 'monthly' ? json_encode($request->monthly_dates) : null,
            'fixed_weekly_days' => $request->type === 'weekly' ? json_encode($request->weekly_days) : null,
        ]);

        $repaymentCycle->save();

        return redirect()->route('repayment_cycles.index')->with('success', 'Repayment cycle created successfully.');
    }

    // Show form to edit repayment cycle
    public function edit(RepaymentCycle $repaymentCycle)
    {
        return view('repayment_cycles.edit', compact('repaymentCycle'));
    }

    // Update a repayment cycle
    public function update(Request $request, RepaymentCycle $repaymentCycle)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:days,monthly,weekly',
            'every_x_days' => 'required_if:type,days|nullable|integer|min:1',
            'monthly_dates' => 'required_if:type,monthly|nullable|array',
            'monthly_dates.*' => 'integer|between:1,31',
            'weekly_days' => 'required_if:type,weekly|nullable|array',
            'weekly_days.*' => 'integer|between:1,7',
        ]);

        $repaymentCycle->update([
            'name' => $request->name,
            'type' => $request->type,
            'every_x_days' => $request->type === 'days' ? $request->every_x_days : null,
            'fixed_monthly_dates' => $request->type === 'monthly' ? json_encode($request->monthly_dates) : null,
            'fixed_weekly_days' => $request->type === 'weekly' ? json_encode($request->weekly_days) : null,
        ]);

        return redirect()->route('repayment_cycles.index')->with('success', 'Repayment cycle updated successfully.');
    }

    // Delete a repayment cycle
    public function destroy(RepaymentCycle $repaymentCycle)
    {
        $repaymentCycle->delete();
        return redirect()->route('repayment_cycles.index')->with('success', 'Repayment cycle deleted successfully.');
    }

    // Show a specific repayment cycle
    public function show(RepaymentCycle $repaymentCycle)
    {
        return view('repayment_cycles.show', compact('repaymentCycle'));
    }
}
