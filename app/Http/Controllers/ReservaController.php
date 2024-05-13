<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Reserva;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'start_date' => 'required|date_format:Y-m-d',
                'end_date' => 'required|date_format:Y-m-d|after:start_date',
                'phone' => 'required|numeric',
                'establishment_id' => 'required|exists:establishments,id'
            ]);

            $start_date = DateTime::createFromFormat('Y-m-d', $validatedData['start_date']);
            $end_date = DateTime::createFromFormat('Y-m-d', $validatedData['end_date']);

            $price = $this->calculateTotalPrice($request->input('establishment_id'), $start_date->format('Y-m-d'), $end_date->format('Y-m-d'));

            $reserva = new Reserva();
            $reserva->user_id = Auth::id();
            $reserva->establishment_id = $request->input('establishment_id');
            $reserva->start_date = $start_date->format('Y-m-d');
            $reserva->end_date = $end_date->format('Y-m-d');
            $reserva->phone = $validatedData['phone'];
            $reserva->price = $price;
            $reserva->status = 'pending';
            $reserva->save();

            return redirect()->route('index')->with('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Reservation made correctly!'
            ]);
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Error in store method: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'There was an error processing your reservation. Please try again later.'
            ]);
        }
    }
    private function calculateTotalPrice($establishmentId, $startDate, $endDate)
    {
        $establishment = Establishment::find($establishmentId);

        if (!$establishment) {
            return 0;
        }

        $startDate = new DateTime($startDate);
        $endDate = new DateTime($endDate);
        $interval = $startDate->diff($endDate);
        $totalDays = $interval->days;

        $totalPrice = $establishment->price * $totalDays;

        return $totalPrice;
    }
}
