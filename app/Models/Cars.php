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
}