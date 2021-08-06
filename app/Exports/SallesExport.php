<?php

namespace App\Exports;

use App\Salle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SallesExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

 /*    public function collection()
    {
        return Salle::all();
    }
    */
    public function view(): View
    {
        return view('excel-salle', [
            'salles' => Salle::all()
        ]);
    }
    
}
