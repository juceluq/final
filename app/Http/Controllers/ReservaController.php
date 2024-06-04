<?php

namespace App\Http\Controllers;

use App\Mail\CancelReservaEmail;
use App\Mail\ReservaEmail;
use App\Models\Establishment;
use App\Models\Reserva;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{

    public function index()
    {
        $userId = auth()->id();
        $establishments = Establishment::with(['reservas' => function ($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->get();

        // Filtrar los establecimientos para solo aquellos que tienen reservas
        $filteredEstablishments = $establishments->filter(function ($establishment) {
            return $establishment->reservas->isNotEmpty();
        });

        if ($filteredEstablishments->isEmpty()) {
            return redirect('/')->with('alert', [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'You don\'t have any reserves!'
            ]);
        }

        return view('myreserves', ['establishments' => $filteredEstablishments]);
    }


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
            $reserva->save();
            $this->sendEmailReserva($reserva);

            return redirect()->back()->with('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Reserve made correctly!'
            ]);
        } catch (Exception $e) {
            Log::error('Error: ' . $e->getMessage());

            return redirect()->back()->with('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'There was an error processing your reserve. Please try again later.'
            ]);
        }
    }

    public function sendEmailReserva($reserva)
    {
        Mail::to(Auth::user()->email)->send(new ReservaEmail($reserva));

        return response()->json(['message' => 'Correo enviado correctamente.']);
    }

    public function sendEmailCancelReserva($reserva)
    {
        Mail::to($reserva->user->email)->send(new CancelReservaEmail($reserva));

        return response()->json(['message' => 'Correo enviado correctamente.']);
    }


    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);

        if ($reserva->user_id === auth()->id() || auth()->user()->role === 'Admin' || auth()->user()->role === 'Business') {
            $reserva->delete();
            $this->sendEmailCancelReserva($reserva);
            return redirect('/')->with('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Your reserve has been canceled successfully!'
            ]);
        }

        return back()->with('alert', [
            'type' => 'error',
            'title' => 'Error!',
            'message' => 'There was an error deleting your reserve. Please try again later.'
        ]);
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
