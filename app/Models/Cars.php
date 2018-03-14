<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 4.3.18.
 * Time: 14.34
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Cars
{
    public function __construct()
    {
    }

    public function getAllCars(){

    }

    public static function getAllCarsForUser($id_u){
        $cars = DB::table("Cars")
            ->join("Brand", "brand_id", "=", "Brand.id")
            ->join("Model", "model_id", "=", "Model.id")
            ->join("Users", "user_id", "=", "Users.id")
            ->leftJoin('Rent', 'Cars.id', '=', 'Rent.car_id')
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName", "Rent.end_date as RentEnd", "Rent.car_id as rentedCar", "Rent.status as RentStatus")
            ->where('Cars.user_id', $id_u)
            ->get();
        return $cars;
    }

    public static function getRented(){
        $cars = DB::table("Cars")
            ->join("Brand", "brand_id", "=", "Brand.id")
            ->join("Model", "model_id", "=", "Model.id")
            ->join("Users", "user_id", "=", "Users.id")
            ->leftJoin('Rent', 'Cars.id', '=', 'Rent.car_id')
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName", "Rent.end_date as RentEnd", "Rent.car_id as rentedCar", "Rent.status as RentStatus", "Rent.price_per_day as price_per_day", "Rent.renter_id")
            ->whereNotNull('Rent.status')
            ->get();

        foreach ($cars as $car){
            if($car->renter_id > 0){
                $renter = DB::table("Users")
                    ->where("id", "=", $car->renter_id)
                    ->get();
                $car->renter = $renter[0]->first_name." ".$renter[0]->last_name;
            }
        }
        return $cars;
    }

    public static function getBrand(){
        $brands = DB::table('Brand')->get();
        return $brands;
    }

    public static function getModelBrand($brand){
        $models = DB::table('Model')
            ->where('brand_id', $brand)
            ->get();
        return $models;
    }

    public static function insertNewBrand($brand){
        $id = DB::table("Brand")
            ->insertGetId(
                [
                    'name' => $brand
                ]
            );
        return $id;
    }
    public static function insertNewModel($brand_id, $model){
        $id = DB::table("Model")
            ->insertGetId(
                [
                    'name' => $model,
                    'brand_id' => $brand_id
                ]
            );
        return $id;
    }

    public static function insertNewCar($brand, $model, $year, $km, $price, $desc, $photo, $user_id){
        $id = DB::table("Cars")
            ->insertGetId(
                [
                    'brand_id' => $brand,
                    'model_id' => $model,
                    'year' => $year,
                    'km_passed' => $km,
                    'price' => $price,
                    'description' => $desc,
                    'photo' => $photo,
                    'user_id' => $user_id
                ]
            );
        return $id;
    }

    public static function addForRend($id, $price){
        $id = DB::table("Rent")
            ->insertGetId(
                [
                    'owner_id' => session()->get('user')[0]->id,
                    'car_id' => $id,
                    'start_date' => null,
                    'end_date' => null,
                    'price_per_day' => $price,
                    'status' => 'available'
                ]
            );
        return $id;
    }

    public static function removeRent($id){
        $res = DB::table('Rent')
            ->where('car_id', '=', $id)
            ->where('status', '=', 'available')
            ->delete();
        return $res;
    }

    public static function cancelRent($id){
        $res = DB::table('Rent')
            ->where('car_id', '=', $id)
            ->where('status', '=', 'rented')
            ->update([
                'status' => 'available'
            ]);
        return $res;
    }

    public static function rentACar($car_id, $user_id, $end){
        $res = DB::table('Rent')
            ->where('car_id', '=', $car_id)
            ->where('status', '=', 'available')
            ->update(
                [
                    'renter_id' => $user_id,
                    'end_date' => $end,
                    'status' => 'rented'
                ]
            );
        if(!empty($res)){
            $user = DB::table("Users")
                ->where("id", '=', $user_id)
                ->get();

        }
        return $user[0]->first_name." ".$user[0]->last_name;
    }

    public static function rentFinished($id){
        $res = DB::table('Rent')
            ->where('car_id', '=', $id)
            ->where('status', '=', 'rented')
            ->update(
                [
                    'renter_id' => 0,
                    'end_date' => null,
                    'status' => 'available'
                ]
            );
        $info = DB::table('Rent')
            ->where('car_id', '=', $id)
            ->get();
        if(!empty($res))
            return $info;
        else
            return null;
    }

    public static function getFiveCars($offset){
        $cars = DB::table('Cars')
            ->offset($offset*2-2)
            ->limit(2)
            ->join("Brand", "brand_id", "=", "Brand.id")
            ->join("Model", "model_id", "=", "Model.id")
            ->join("Users", "user_id", "=", "Users.id")
            ->leftJoin('Rent', 'Cars.id', '=', 'Rent.car_id')
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName", "Rent.end_date as RentEnd", "Rent.car_id as rentedCar", "Rent.status as RentStatus")
            ->get();

        $num = DB::table('Cars')
            ->count();

        $cars[0]->num = $num;

        return $cars;
    }

    public static function updateCar($id, $brand, $model, $price, $km, $year, $desc){
        $res = DB::table('Cars')
            ->where('id', '=', $id)
            ->update(
                [
                    'brand_id' => $brand,
                    'model_id' => $model,
                    'price' => $price,
                    'km_passed' => $km,
                    'year' => $year,
                    'description' => $desc
                ]
            );
        return $res;
    }

    public static function deleteCar($id){
        $a = DB::table('Rent')
            ->where('car_id', '=', $id)
            ->delete();

        $res = DB::table('Cars')
            ->where('id', '=', $id)
            ->delete();


        return $res;
    }

    public static function deleteBrand($brands){
        $a = DB::table('Model')
            ->whereIn('brand_id', $brands)
            ->delete();

        $res = DB::table('Brand')
            ->whereIn('id', $brands)
            ->delete();
        return $res;
    }

    public static function deleteModels($models){
        $a = DB::table('Model')
            ->whereIn('id', $models)
            ->delete();

        return $a;
    }

    public static function getMyRentedCars(){
        $cars = DB::table("Cars")
            ->join("Brand", "brand_id", "=", "Brand.id")
            ->join("Model", "model_id", "=", "Model.id")
            ->join("Users", "user_id", "=", "Users.id")
            ->leftJoin('Rent', 'Cars.id', '=', 'Rent.car_id')
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName", "Rent.end_date as RentEnd", "Rent.car_id as rentedCar", "Rent.status as RentStatus", "Rent.price_per_day as price_per_day", "Rent.renter_id")
            ->where('Rent.status', '=', 'rented')
            ->where('renter_id', '=', session()->get('user')[0]->id)
            ->get();

        return $cars;
    }

    public static function getGallery(){
        $res = DB::table('Gallery')
            ->where('type', '=', 'gallery')
            ->get();
        return $res;
    }

    public static function getSlider(){
        $res = DB::table('Gallery')
            ->where('type', '=', 'slider')
            ->get();
        return $res;
    }
}