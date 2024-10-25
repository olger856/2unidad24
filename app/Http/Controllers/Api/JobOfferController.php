<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobOffer; // Asegúrate de tener el modelo JobOffer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobOfferController extends Controller
{
    // Listar ofertas laborales
    public function index()
    {
        $jobOffers = JobOffer::all();
        return response()->json($jobOffers);
    }

    // Crear una nueva oferta laboral
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jobOffer = JobOffer::create([
            'empresa_id' => $request->empresa_id, // Asegúrate de enviar el ID de la empresa
            'title' => $request->title,
            'description' => $request->description,
            'location' => $request->location,
            'salary' => $request->salary,
            'image' => $request->image,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json($jobOffer, 201);
    }

    // Mostrar una oferta laboral específica
    public function show($id)
    {
        $jobOffer = JobOffer::find($id);

        if (!$jobOffer) {
            return response()->json(['message' => 'Oferta laboral no encontrada'], 404);
        }

        return response()->json($jobOffer);
    }

    // Actualizar una oferta laboral
    public function update(Request $request, $id)
    {
        $jobOffer = JobOffer::find($id);

        if (!$jobOffer) {
            return response()->json(['message' => 'Oferta laboral no encontrada'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'location' => 'sometimes|nullable|string|max:255',
            'salary' => 'sometimes|nullable|numeric',
            'image' => 'sometimes|nullable|string|max:255',
            'start_date' => 'sometimes|nullable|date',
            'end_date' => 'sometimes|nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $jobOffer->update($request->all());

        return response()->json($jobOffer);
    }

    // Eliminar una oferta laboral
    public function destroy($id)
    {
        $jobOffer = JobOffer::find($id);

        if (!$jobOffer) {
            return response()->json(['message' => 'Oferta laboral no encontrada'], 404);
        }

        $jobOffer->delete();

        return response()->json(['message' => 'Oferta laboral eliminada']);
    }
}
