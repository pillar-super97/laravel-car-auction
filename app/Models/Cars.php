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
            ->select("Cars.*", "Brand.name as brand", "Model.name as model", "Users.first_name as FirstName", "Users.last_name as LastName")
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
}