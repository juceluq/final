<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class EstablishmentController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Verificar si el usuario no es administrador
            if ($user->role != 'Admin') {

                // Obtener los IDs de los establecimientos que el usuario ha reservado
                $reservedEstablishmentIds = $user->reservas->pluck('establishment_id')->toArray();

                // Obtener los establecimientos que pertenecen al usuario y excluir los que ha reservado
                $establishments = Establishment::where('user_id', $user->id)
                    ->whereNotIn('id', $reservedEstablishmentIds)
                    ->get();

                // Obtener los establecimientos de otros usuarios que no han sido reservados por el usuario autenticado
                $otherEstablishments = Establishment::where('user_id', '!=', $user->id)
                    ->whereNotIn('id', $reservedEstablishmentIds)
                    ->get();

                // Combinar las dos colecciones
                $establishments = $establishments->merge($otherEstablishments);
            } else {
                // Si el usuario es administrador, obtener todos los establecimientos
                $establishments = Establishment::all();
            }
        } else {
            // Si el usuario no está autenticado, obtener todos los establecimientos
            $establishments = Establishment::all();
        }

        return view('index', compact('establishments'));
    }





    public function mybusinesses()
    {
        $user = Auth::user();
        $establishments = Establishment::where('user_id', $user->id)->get();

        // Verificar si no hay establecimientos
        if ($establishments->isEmpty()) {
            return redirect('/')->with('alert', [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'You don\'t have any businesses!'
            ]);
        }

        return view('mybusinesses', compact('establishments'));
    }


    public function show($id)
    {
        $establishment = Establishment::findOrFail($id);
        $reviews = $establishment->reviews()
            ->withCount(['votes as useful_votes' => function ($query) {
                $query->where('type', '1');
            }, 'votes as not_useful_votes' => function ($query) {
                $query->where('type', '0');
            }])
            ->get()
            ->sortByDesc(function ($review) {
                return $review->useful_votes - $review->not_useful_votes;
            });
        $averageRating = $reviews->avg('rating');
        if (Auth::check()) {
            $user = Auth::user();
            $alreadyReserved = Reserva::where('user_id', $user->id)
                ->where('establishment_id', $id)
                ->exists();
            $reservas = $establishment->reservas;
            $reservas = Reserva::where('establishment_id', $id)->get();

            $userId = auth()->id();

            $reserva = Reserva::where('user_id', $userId)
                ->where('establishment_id', $id)
                ->first();

            $reservaId = $reserva?->id;
            $reservation = Reserva::where('establishment_id', $establishment->id)
                ->where('user_id', Auth::user()->id)
                ->first();



            return view('establishment.establishment', compact('establishment', 'alreadyReserved', 'reservas', 'reviews', 'averageRating', 'reservation', 'reservaId'));
        } else {
            return view('establishment.establishment', compact('establishment', 'reviews', 'averageRating'));
        }
    }


    public function create()
    {
        if (Auth::user()->role !== 'Admin' && Auth::user()->role !== 'Business') {
            return redirect('/')->with('alert', [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'You dont are authorize to enter this page!'
            ]);
        }

        return view('establishment.create');
    }

    public function edit(Establishment $establishment)
    {

        return view('establishment.edit', compact('establishment'));
    }

    public function update(Request $request, Establishment $establishment)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric',
            'images' => 'sometimes|array|max:3',
            'images.*' => 'image|max:15000',
        ]);

        $folderName = 'IMG_' . $establishment->id;
        $folderPath = 'public/images/' . $folderName;

        if (!Storage::exists($folderPath)) {
            Storage::makeDirectory($folderPath);
        }

        $totalImages = 0;

        if ($request->hasFile('images')) {
            $existingImages = $establishment->images;

            foreach ($existingImages as $image) {
                Storage::delete('public/' . $image->filename);
                $image->delete();
            }

            foreach ($request->file('images') as $index => $file) {
                $newFileName = ($index + 1) . '.' . $file->extension();
                $file->storeAs($folderPath, $newFileName);
                $establishment->images()->create(['filename' => $folderName . '/' . $newFileName]);
                $totalImages++;
            }
        } else {
            // No se han subido nuevas imágenes, conservamos las existentes
            $totalImages = $establishment->images()->count();
        }

        for ($i = $totalImages + 1; $i <= 3; $i++) {
            $defaultImageFile = 'default/default.jpg';
            $defaultFileName = $i . '.jpg';
            Storage::copy('public/images/' . $defaultImageFile, $folderPath . '/' . $defaultFileName);
            $establishment->images()->create(['filename' => $folderName . '/' . $defaultFileName]);
        }

        $establishment->update($validatedData);

        return redirect()->route('index')->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Establishment updated successfully!'
        ]);
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

            return redirect('/')->with('alert', [
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

    public function search(Request $request)
    {
        $query = $request->input('query');
        $establishments = Establishment::where('name', 'LIKE', "%$query%")
            ->orWhere('description', 'LIKE', "%$query%")
            ->get();

        return view('index', compact('establishments'));
    }
}
