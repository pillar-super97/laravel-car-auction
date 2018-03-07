<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 5.3.18.
 * Time: 21.23
 */

namespace App\Http\Controllers;


use App\Models\Cars;
use Illuminate\Http\Request;

class MyCarsController
{
    public function render(){
        $cars = Cars::getAllCarsForUser(session()->get('user')[0]->id);
        return view("pages.mycar", ['cars' => $cars]);
    }

    public function addForRent(Request $request){
        if($request->ajax()){
            $id_car = $request->get('id');
            $start = $request->get('start');
            $end = $request->get('end');
            $price = $request->get('price');

            $id = Cars::addForRend($id_car, $start, $end, $price);
            if(!empty($id)){
                return response('success');
            }
        }
    }
    public function proba(){
        $proba = Cars::proba();
        dd($proba);
    }
}