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
            $price = $request->get('price');

            $id = Cars::addForRend($id_car, $price);
            if(!empty($id)){
                return response('success');
            }
        }
    }

    public function removeRent(Request $request){
        if($request->ajax()){
            $id_car = $request->get('id');

            $res = Cars::removeRent($id_car);

            if(!empty($res)){
                return response($res);
            }

        }
    }

    public function cancelRent(Request $request){
        if($request->ajax()){
            $id_car = $request->get('id');

            $res = Cars::cancelRent($id_car);

            if(!empty($res)){
                return response($res);
            }

        }
    }

    public function getRented(){
        $cars = Cars::getMyRentedCars();

        return view('pages.rented', ['cars' => $cars]);
    }
}