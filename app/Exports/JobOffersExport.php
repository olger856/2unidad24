<?php

namespace App\Exports;

use App\Models\JobOffer;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobOffersExport implements FromCollection

{
    public function collection()
    {
        return JobOffer::with('user')->get(); // Carga las ofertas laborales con la relación de usuario
    }
}
