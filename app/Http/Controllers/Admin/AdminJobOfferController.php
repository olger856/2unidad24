<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOffer;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminJobOfferController extends Controller
{
    // Listar todas las ofertas laborales con búsqueda
    public function index(Request $request)
    {
        $search = $request->input('search');

        $job_offers = JobOffer::with('user')
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhereHas('user', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
            })
            ->get();

        return view('admin.job_offers.index', compact('job_offers', 'search'));
    }

    // Mostrar el formulario para crear una nueva oferta
    public function create()
    {
        $empresas = User::where('rol', '2')->get();
        return view('admin.job_offers.create', compact('empresas'));
    }

    // Guardar una nueva oferta laboral
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'empresa_id' => 'required|exists:users,id',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('job_offers', 'public');
        }

        JobOffer::create([
            'title' => $request->title,
            'description' => $request->description,
            'empresa_id' => $request->empresa_id,
            'location' => $request->location,
            'salary' => $request->salary,
            'image' => $imagePath,
            'start_date' => Carbon::parse($request->start_date),
            'end_date' => Carbon::parse($request->end_date),
        ]);

        return redirect()->route('admin.job_offers.index')->with('status', 'Oferta de trabajo creada exitosamente.');
    }

    // Mostrar el formulario para editar una oferta laboral existente
    public function edit(JobOffer $jobOffer)
    {
        $empresas = User::where('rol', '2')->get();
        $jobOffer->start_date = Carbon::parse($jobOffer->start_date);
        $jobOffer->end_date = Carbon::parse($jobOffer->end_date);
        
        return view('admin.job_offers.edit', compact('jobOffer', 'empresas'));
    }

    // Actualizar una oferta laboral existente
    public function update(Request $request, JobOffer $jobOffer)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'empresa_id' => 'required|exists:users,id',
            'location' => 'nullable|string|max:255',
            'salary' => 'nullable|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $data = $request->only(['title', 'description', 'empresa_id', 'location', 'salary']);
        $data['start_date'] = Carbon::parse($request->start_date);
        $data['end_date'] = Carbon::parse($request->end_date);

        if ($request->hasFile('image')) {
            if ($jobOffer->image) {
                Storage::disk('public')->delete($jobOffer->image);
            }
            $imagePath = $request->file('image')->store('job_offers', 'public');
            $data['image'] = $imagePath;
        }

        $jobOffer->update($data);

        return redirect()->route('admin.job_offers.index')->with('status', 'Oferta de trabajo actualizada exitosamente.');
    }

    // Eliminar una oferta laboral
    public function destroy(JobOffer $jobOffer)
    {
        if ($jobOffer->image) {
            Storage::disk('public')->delete($jobOffer->image);
        }

        $jobOffer->delete();
        return redirect()->route('admin.job_offers.index')->with('status', 'Oferta de trabajo eliminada exitosamente.');
    }

    // Método para exportar a PDF una oferta laboral específica
    public function export($id, $format)
    {
        $offer = JobOffer::with('user', 'jobApplications')->findOrFail($id);

        // Contar el número de postulantes
        $numberOfApplicants = $offer->jobApplications->count();

        if ($format === 'pdf') {
            $pdf = FacadePdf::loadView('pdf.job_offer', compact('offer', 'numberOfApplicants'));
            return $pdf->download('oferta_' . $offer->id . '.pdf');
        }

        if ($format === 'csv') {
            $csvFileName = 'oferta_' . $offer->id . '.csv';
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Título', 'Descripción', 'Ubicación', 'Salario', 'Fecha de Inicio', 'Fecha de Fin', 'Nombre de la Empresa']);

            fputcsv($handle, [
                $offer->id,
                $offer->title,
                $offer->description,
                $offer->location,
                $offer->salary,
                $offer->start_date,
                $offer->end_date,
                $offer->user->name ?? 'No asignada'
            ]);

            fclose($handle);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
            exit();
        }

        return redirect()->back()->with('error', 'Formato no soportado.');
    }

    // Método para exportar todas las ofertas laborales a PDF o CSV
    public function exportAll(Request $request, $format)
    {
        $job_offers = JobOffer::with('user')->get();

        if ($format === 'pdf') {
            $pdf = FacadePdf::loadView('admin.job_offers.pdf', compact('job_offers'));
            return $pdf->download('ofertas_laborales.pdf');
        }

        if ($format === 'csv') {
            $csvFileName = 'ofertas_laborales.csv';
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Título', 'Descripción', 'Ubicación', 'Salario', 'Fecha de Inicio', 'Fecha de Fin', 'Nombre de la Empresa']);

            foreach ($job_offers as $offer) {
                fputcsv($handle, [
                    $offer->id,
                    $offer->title,
                    $offer->description,
                    $offer->location,
                    $offer->salary,
                    $offer->start_date,
                    $offer->end_date,
                    $offer->user->name ?? 'No asignada'
                ]);
            }

            fclose($handle);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $csvFileName . '"');
            exit();
        }

        return redirect()->back()->with('error', 'Formato no soportado.');
    }
}
