<?php

namespace App\Exports;
use App\Groupe;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class GroupeExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
   */
    public function view(): View
    {
        return view('excel-groupe', [
            'groupe' => Groupe::all()
        ]);
    }
}
