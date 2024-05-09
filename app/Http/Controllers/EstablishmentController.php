<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EstablishmentController extends Controller
{
    public function index()
    {
        $establishments = Establishment::all();
        return view('index', compact('establishments'));
    }

    public function show($id)
    {
        $establishment = Establishment::findOrFail($id);
        return view('establishment.establishment', compact('establishment'));
    }


    public function create()
    {
        return view('establishment.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'sometimes|file|image|max:5000',
        ]);


        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('images', 'public');
        } else {
            $validated['image'] = 'images/default.jpg';
        }

        $validated['user_id'] = auth()->id();

        $establishment = Establishment::create($validated);

        return redirect()->route('index')->with('success', 'Establishment created successfully!');
    }

    public function destroy(Establishment $establishment)
    {
        if ($establishment->image !== 'images/default.jpg') {
            Storage::delete('public/' . $establishment->image);
        }
        $establishment->delete();

        return back()->with('success', 'Establishment deleted successfully!');
    }
}
