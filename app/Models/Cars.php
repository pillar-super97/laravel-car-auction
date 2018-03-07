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
            ->leftJoin('Licitation', 'Cars.id', '=', 'Licitation.car_id')
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName", "Rent.end_date as RentEnd", "Rent.car_id as rentedCar", "Licitation.status as AuctionStatus", "Licitation.car_id as auctionCar", "Licitation.end_time as AuctionEnd")
            ->where('Cars.user_id', $id_u)
            ->get();
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

    public static function addForRend($id, $start, $end, $price){
        $id = DB::table("Rent")
            ->insertGetId(
                [
                    'owner_id' => session()->get('user')[0]->id,
                    'car_id' => $id,
                    'start_date' => $start,
                    'end_date' => $end,
                    'price_per_day' => $price
                ]
            );
        return $id;
    }

    public static function proba(){
        $res = DB::table("Rent")
            ->orderBy("end_date", "asc")
            ->get();
        return $res;
    }
}