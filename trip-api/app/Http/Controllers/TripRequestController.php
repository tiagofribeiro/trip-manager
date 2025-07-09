<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TripRequest;

// TODO: DTOs?

/**
 * @group Trips
 */
class TripRequestController extends Controller
{
    /**
     * @authenticated
     */
    public function getAll(Request $request)
    {
        $query = TripRequest::where('user_id', auth()->id());

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('destination')) {
            $query->where('destination', 'like', "%{$request->destination}%");
        }

        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('departure_date', [$request->start_date, $request->end_date]);
        }

        return response()->json($query->get(), 200);
    }

    /**
     * @authenticated
     */
    public function getOne($trip_request_id)
    {
        $query = TripRequest::where('user_id', auth()->id())
            ->where('id', $trip_request_id);
        return response()->json($query->first(), 200);

    }

    /**
     * @authenticated
     */
    public function create(Request $request)
    {
        // TODO: conflito de datas simultâneas?

        $request->validate([
            'destination' => 'required|string|max:255',
            'departure_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:departure_date',
        ]);

        TripRequest::create([
            'user_id' => auth()->id(),
            'destination' => $request->destination,
            'departure_date' => $request->departure_date,
            'return_date' => $request->return_date
        ]);

        return response()->json(['message' => 'Solicitação criada com sucesso', 201]);

    }

    // TODO: limitar funcionalidades abaixo para Admin?

    /**
     * @authenticated
     */
    public function update(Request $request, $trip_request_id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $trip = TripRequest::where('user_id', auth()->id())
            ->where('id', $trip_request_id)
            ->first();

        $trip->update(['status' => $request->status]);

        return response()->json(['message' => 'Solicitação atualizada com sucesso'], 200);

    }

    /**
     * @authenticated
     */
    public function cancel($trip_request_id)
    {
        $trip = TripRequest::where('user_id', auth()->id())
            ->where('id', $trip_request_id)
            ->first();

        if ($trip->status === 'approved') {
            return response()->json(['message' => 'Não é possível cancelar uma solicitação aprovada'], 400);
        }

        $trip->update(['status' => 'rejected']);

        return response()->json(['message' => 'Pedido cancelado com sucesso'], 200);
    }
}
