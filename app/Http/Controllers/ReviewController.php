<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Review;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'comment' => 'required|string',
                'establishment_id' => 'required|exists:establishments,id',
                'reserva_id' => 'required|exists:reservas,id',
            ]);

            $review = new Review();
            $review->comment = $request->comment;
            $review->user_id = auth()->id();
            $review->establishment_id = $request->establishment_id;
            $review->reserva_id = $request->reserva_id;
            $review->rating = $request->rating;
            $review->review_date = now();
            $review->votes = 0;
            $review->save();

            return back()->with('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Your post has been submitted.'
            ]);
        } catch (QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());

            return back()->with('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'ERROR' . $e->getMessage(),
            ]);
        } catch (\Exception $e) {
            Log::error('General error: ' . $e->getMessage());

            return back()->with('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'ERROR' . $e->getMessage(),
            ]);
        }
    }

    public function destroy(Review $review)
    {
        if (Auth::check($review->delete())) {
        }


        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Your post has been deleted.',
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $review = Review::findOrFail($id);

        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->save();

        return redirect()->back()->with('alert', [
            'type' => 'success',
            'title' => 'Success!',
            'message' => 'Your post has been updated successfully.',
        ]);;
    }

    public function sortReviews(Request $request)
    {
        $establishmentId = $request->establishmentId; 
        $sortBy = $request->sortBy;
    
        $establishment = Establishment::findOrFail($establishmentId);
        $query = $establishment->reviews();
    
        switch ($sortBy) {
            case 'votes_desc':
                $query->orderBy('votes', 'desc');
                break;
            case 'votes_asc':
                $query->orderBy('votes', 'asc');
                break;
            case 'rating_desc':
                $query->orderBy('rating', 'desc');
                break;
            case 'rating_asc':
                $query->orderBy('rating', 'asc');
                break;
        }
    
        $reviews = $query->get();
    
        return view('partials.reviews', compact('reviews')); 
    }
    
}
