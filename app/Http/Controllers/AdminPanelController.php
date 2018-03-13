<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 11.3.18.
 * Time: 15.01
 */

namespace App\Http\Controllers;


use App\Models\Cars;
use App\Models\User;
use Illuminate\Http\Request;

class AdminPanelController
{
    public function __construct()
    {
    }

    public function render(){
        $users = User::getAll();
        $cars = Cars::getFiveCars(0);
        $brands = Cars::getBrand();

        return view('pages.adminpanel', ['users' => $users, 'cars' => $cars, 'brands' => $brands]);
    }

    public function updateUser(Request $request){
        if($request->ajax()){
            $id = $request->get('id');
            $name = $request->get('name');
            $lastname = $request->get('lastname');
            $username = $request->get('username');
            $email = $request->get('email');
            $role = $request->get('role');

            $res = User::updateUser($id, $name, $lastname, $username, $email, $role);

            if(!empty($res)){
                return response('success');
            }
        }
    }

    public function deleteUser(Request $request){
        if($request->ajax()){
            $id = $request->get('id');

            $res = User::deleteUser($id);

            if($res == 1)
                return response('success');
        }
    }

    public function paginateCars(Request $request){
        if($request->ajax()){
            $offset = $request->get('offset');
            $cars = Cars::getFiveCars($offset);

            if(!empty($cars)){
                return response()->json([
                    'message' => 'success',
                    'cars' => $cars
                ]);
            }
        }
    }

    public function getBrands(Request $request){
        if($request->ajax()){
            $brands = Cars::getBrand();

            if(!empty($brands)){
                return response()->json([
                    'message' => 'success',
                    'brands' => $brands
                ]);
            }
        }
    }

    public function updateCar(Request $request){
        if($request->ajax()){
            $id = $request->get('id');
            $brand = $request->get('brand');
            $model = $request->get('model');
            $price = $request->get('price');
            $year = $request->get('year');
            $km = $request->get('km');
            $desc = $request->get('description');

            if(is_numeric($model)){
                $res = Cars::updateCar($id, $brand, $model, $price, $km, $year, $desc);
                if(!empty($res))
                    return response('success');
            }
            else{
                $new_model = Cars::insertNewModel($brand, $model);
                $res = Cars::updateCar($id, $brand, $new_model, $price, $km, $year, $desc);
                if(!empty($res))
                    return response('success');
            }
        }
    }

    public function deleteCar(Request $request){
        if($request->ajax()){
            $id = $request->get('id');
            $res = Cars::deleteCar($id);
            if($res == 1)
                return response('success');
        }
    }

    public function insertBrand(Request $request){
        if($request->ajax()){
            $brand = $request->get('brand');
            $id = Cars::insertNewBrand($brand);

            if(!empty($id)){
                return response()->json([
                    'message' => 'success',
                    'id' => $id
                ]);
            }
        }
    }

    public function deleteBrand(Request $request){
        if($request->ajax()){
            $brands = $request->get('selected');
            $res = Cars::deleteBrand($brands);

            if($res > 0){
                return response('success');
            }
        }
    }

    public function getModels(Request $request){
        if($request->ajax()){
            $brand = $request->get('id');
            $res = Cars::getModelBrand($brand);

            if(!empty($res)){
                return response()->json([
                    'message' => 'success',
                    'models' => $res
                ]);
            }
            else{
                return response()->json([
                    'message' => 'empty',
                    'models' => null
                ]);
            }
        }
    }

    public function insertModel(Request $request){
        if($request->ajax()){
            $brand = $request->get('brand');
            $model = $request->get('model');
            $id = Cars::insertNewModel($brand, $model);

            if(!empty($id)){
                return response()->json([
                    'message' => 'success',
                    'id' => $id
                ]);
            }
        }
    }

    public function deleteModels(Request $request){
        if($request->ajax()){
            $models = $request->get('selected');
            $res = Cars::deleteModels($models);

            if($res > 0){
                return response('success');
            }
        }
    }
}