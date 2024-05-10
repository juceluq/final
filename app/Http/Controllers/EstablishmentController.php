<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
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
        //TODO Falta poner el limite de la imagen
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'file|image|max:16000',
        ],
    );
        $validated['image'] = 'images/default.jpg';
        $validated['user_id'] = auth()->id();

        $establishment = Establishment::create($validated);

        if ($request->hasFile('image')) {
            $newFileName = 'IMG_' . $establishment->id . '.' . $request->file('image')->extension();
            $path = $request->file('image')->storeAs('images', $newFileName, 'public');

            $establishment->image = $newFileName;
            $establishment->save();
        }

        return redirect()->route('index')->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Establishment created successfully!'
        ]);;
    }


    public function destroy(Establishment $establishment)
    {
        if (Auth::user()->role === 'Admin' || (Auth::user()->role === 'Business' && $establishment->user_id === Auth::user()->id)) {
            if ($establishment->image !== 'images/default.jpg') {
                Storage::delete('public/' . $establishment->image);
            }
            $establishment->delete();

            return back()->with('alert', [
                'type' => 'success',
                'title' => 'Successful!',
                'message' => 'Establishment deleted successfully!'
            ]);
        }
        return back()->with('alert', [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'You are not authorized to delete this establishment!'
        ]);
    }
}
