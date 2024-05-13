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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'images' => 'sometimes|array|max:3',
            'images.*' => 'image|max:5000',
        ]);
    
        $validated['user_id'] = auth()->id();
    
        $establishment = Establishment::create($validated);
        $folderName = 'IMG_' . $establishment->id;
        $defaultImage = 'default.jpg';
        $uploadedImageCount = $request->hasFile('images') ? count($request->file('images')) : 0;
    
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $newFileName = $index + 1 . '.' . $image->extension();
                $path = $image->storeAs('images/' . $folderName, $newFileName, 'public');
                $establishment->images()->create(['filename' => $folderName . '/' . $newFileName]);
            }
        }
    
        for ($i = $uploadedImageCount; $i < 3; $i++) {
            $establishment->images()->create(['filename' => 'default/' . $defaultImage]);
        }
    
        return redirect()->route('index')->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Establishment created successfully with images!'
        ]);
    }
    



    public function destroy(Establishment $establishment)
    {
        if (Auth::user()->role === 'Admin' || (Auth::user()->role === 'Business' && $establishment->user_id === Auth::user()->id)) {
            $directory = 'public/images/IMG_' . $establishment->id;

            Storage::deleteDirectory($directory);

            $establishment->delete();

            return back()->with('alert', [
                'type' => 'success',
                'title' => 'Successful!',
                'message' => 'Establishment and all associated images deleted successfully!'
            ]);
        }

        return back()->with('alert', [
            'type' => 'danger',
            'title' => 'Error!',
            'message' => 'You are not authorized to delete this establishment!'
        ]);
    }
}
