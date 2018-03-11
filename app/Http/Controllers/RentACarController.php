<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 8.3.18.
 * Time: 22.01
 */

namespace App\Http\Controllers;


use App\Models\Cars;
use Illuminate\Http\Request;

class RentACarController
{

    public function __construct()
    {
    }

    public function render(){
        $cars = Cars::getRented();

        if(!empty($cars)){
            return view('pages.rentacar', ['cars'=>$cars]);
        }
    }

    public function rentACar(Request $request){
        if($request->ajax()){
            $id_car = $request->get('id');
            $end = $request->get('end');
            $user_id = session()->get('user')[0]->id;

            $res = Cars::rentACar($id_car, $user_id, $end);

            if(!empty($res))
                return response('success');
        }
    }

    public function rentFinished(Request $request){
        if($request->ajax()){
            $id_car = $request->get('id');
            $res = Cars::rentFinished($id_car);

            if(!is_null($res)){
                return response()->json([
                    'message' => 'success',
                    'owner' => $res[0]->owner_id,
                    'session' => session()->has('user') ? session()->get('user')[0]->id : null
                ]);
            }
        }
    }
}