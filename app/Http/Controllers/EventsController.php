<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
class EventsController extends Controller
{
 public function index(){
   return $this->calendrier(Event::all());
 }
 
    public function calendrier($events){

    $eventTab = [];
foreach ($events as $event) {
$data=[
   "title"=> $event->title,
   "start"=>$event->debut,
   "end"=>$event->fin
];
array_push($eventTab, $data);

    }
return response()->json($eventTab);
 }

}


