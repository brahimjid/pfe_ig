<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Creneaujours;

class creneaujoursController extends Controller
{
   
public function index(){

        return view('crudCreneauxJour');

    }

    ## AJAX request
    public function getASC(Request $request){
        ## Read values
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length'); 

        $columnIndex_arr = $request->get('order'); 
        $columnName_arr = $request->get('columns'); 
        $order_arr = $request->get('order'); 
        $search_arr = $request->get('search'); 

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortorder = $order_arr[0]['dir'];//asc or desc
        $searchValue = $search_arr['value'];

        $totalRecords = Creneaujours::select('count(*) as allcount')->count();

        $totalRecordswithFilter = Creneaujours::select('count(*) as allcount')
                                    ->where('idJour','like','%'.$searchValue.'%')
                                    ->count();

        $records = Creneaujours::orderby($columnName,$columnSortorder)   
                            ->where('creneaujours.idJour','like','%'.$searchValue.'%')
                            ->select('jours.jour','creneaux.heureDebut', 'creneaux.heureFin')
                            ->join('jours','creneaujours.idJour','jours.id')
                            ->join('creneaux','creneaujours.idCreneau','creneaux.id')
                            ->skip($start)
                            ->take($rowperpage)
                            ->get();

        $data_arr = array();

//
    
          foreach($records as $record){
            $jour = $record->jour;
            $heureDebut = $record->heureDebut;
             $heureFin = $record->heureFin;
           
        
            $data_arr[] = array(
                "jour" => $jour,
                "heureDebut" => $heureDebut,
                "heureFin" => $heureFin
            );
            
         }

             

         $response = array(
            "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordswithFilter,
        "aaData" => $data_arr
         );

        echo json_encode($response);
        exit;

         }


}
