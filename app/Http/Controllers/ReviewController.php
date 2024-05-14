<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
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
        $review->review_date = now();
        $review->save();
    
        return back()->with('success', 'Review posted successfully!');
    }
    
}
