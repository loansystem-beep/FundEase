<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Disburser;

class DisburserController extends Controller
{
    public function index()
    {
        $disbursers = Disburser::all();
        return view('disbursers.index', compact('disbursers'));
    }

    public function show($id)
    {
        $disburser = Disburser::findOrFail($id);
        return view('disbursers.show', compact('disburser'));
    }

    public function create()
    {
        return view('disbursers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Disburser::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('disbursers.index')->with('success', 'Disburser created successfully.');
    }

    public function edit($id)
    {
        $disburser = Disburser::findOrFail($id);
        return view('disbursers.edit', compact('disburser'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $disburser = Disburser::findOrFail($id);
        $disburser->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('disbursers.index')->with('success', 'Disburser updated successfully.');
    }

    public function destroy($id)
    {
        $disburser = Disburser::findOrFail($id);
        $disburser->delete();

        return redirect()->route('disbursers.index')->with('success', 'Disburser deleted successfully.');
    }
}
