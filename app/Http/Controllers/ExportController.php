<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function exportUsersPDF()
    {
        // Obtén los usuarios de la base de datos
        $postulantes = User::where('rol', User::POSTULANTE)->get();

        // Genera el PDF con una vista específica
        $pdf = FacadePdf::loadView('exports.users-pdf', compact('postulantes'));

        // Descarga el PDF
        return $pdf->download('lista-de-postulantes.pdf');
    }

    public function exportEmpresasPDF()
    {
        // Filtrar solo a los usuarios que tienen el rol de 'Empresa'
        $empresas = User::where('rol', User::EMPRESA)->get(); // Asumiendo que tienes una constante para el rol 'EMPRESA'

        // Generar el PDF con la vista 'exports.empresas-pdf' y los datos de las empresas
        $pdf = FacadePdf::loadView('exports.empresas-pdf', compact('empresas'));

        // Descargar el PDF
        return $pdf->download('lista-de-empresas.pdf');
    }
    public function exportJobOffersToPdf()
    {
        $jobOffers = JobOffer::all(); // O la lógica que uses para obtener las ofertas laborales

        // Lógica para generar el PDF
        $pdf = FacadePdf::loadView('exports.job_offers_pdf', compact('jobOffers'));

        // Define el nombre y la ubicación del archivo PDF
        $filePath = public_path('exports/ofertas/' . 'ofertas_laborales_' . date('Ymd_His') . '.pdf');

        // Guarda el PDF en la carpeta especificada
        $pdf->save($filePath);

        // Retornar el archivo o redireccionar según sea necesario
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function exportSupervisoresPDF()
    {
        // Obtener todos los supervisores (ajusta según tus requerimientos)
        $supervisores = User::where('role', 'supervisor')->get();

        // Define el nombre y la ubicación del archivo PDF
        $directoryPath = public_path('exports/supervisores');

        // Verifica si la carpeta existe; si no, la crea
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $filePath = $directoryPath . '/supervisores_' . date('Ymd_His') . '.pdf';

        // Genera el PDF usando la vista que crearás
        $pdf = FacadePdf::loadView('exports.supervisores_pdf', compact('supervisores'));
        $pdf->save($filePath); // Guarda el PDF en la carpeta especificada

        // Retornar el archivo o redireccionar según sea necesario
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function exportPostulacionesPDF()
    {
        // Obtener las ofertas laborales a las que el usuario ha postulado
        $jobOffers = Auth::user()->jobOffers; // Ajusta esto según tu relación en el modelo User

        // Define el nombre y la ubicación del archivo PDF
        $directoryPath = public_path('exports/postulaciones');

        // Verifica si la carpeta existe; si no, la crea
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $filePath = $directoryPath . '/postulaciones_' . date('Ymd_His') . '.pdf';

        // Genera el PDF usando la vista que crearás
        $pdf = FacadePdf::loadView('exports.postulaciones_pdf', compact('jobOffers'));
        $pdf->save($filePath); // Guarda el PDF en la carpeta especificada

        // Retornar el archivo o redireccionar según sea necesario
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    public function exportPostulacionesEmpresaPDF(JobOffer $jobOffer)
    {
        // Obtener los postulantes para la oferta laboral especificada
        $postulantes = $jobOffer->postulantes; // Asegúrate de tener la relación correctamente definida
        $postulantes = $jobOffer->postulantes()->withPivot('status')->get();

        // Definir el nombre y la ubicación del archivo PDF
        $directoryPath = public_path('exports/Empresapostulaciones');

        // Verifica si la carpeta existe; si no, la crea
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0755, true); // Cambiado a 0755 por seguridad
        }

        $filePath = $directoryPath . '/postulaciones_' . $jobOffer->id . '_' . date('Ymd_His') . '.pdf';

        // Genera el PDF usando la vista que crearás
        try {
            $pdf = FacadePdf::loadView('exports.Empresapostulaciones_pdf', compact('postulantes', 'jobOffer'));
            $pdf->save($filePath); // Guarda el PDF en la carpeta especificada
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo generar el PDF: ' . $e->getMessage()], 500);
        }

        // Retornar el archivo o redireccionar según sea necesario
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

}
