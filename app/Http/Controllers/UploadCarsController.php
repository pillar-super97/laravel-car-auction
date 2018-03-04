<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 4.3.18.
 * Time: 11.44
 */

namespace App\Http\Controllers;


use App\Models\Cars;
use Illuminate\Http\Request;

class UploadCarsController
{
    public function render(){

        $brands = Cars::getBrand();

        return view('pages.postcar', ['brands' => $brands]);
    }

    public function getModel(Request $request){
        if($request->ajax()){
            $brand_id = $request->get('brand');
            $models = Cars::getModelBrand($brand_id);

            if(count($models)>0){
                return response()->json([
                    'status' => 'has',
                    'models' => $models
                ]);
            }
            else{
                return response()->json([
                    'status' => 'empty'
                ]);
            }
        }
    }

    public function uploadCar(Request $request){
        $request->validate([
            'ddlBrand' => ['required'],
            'ddlModel' => ['required'],
            'ddlYear' => ['required'],
            'nbKm' => 'required',
            'nbPrice' => 'required',
            'taDescription' => 'required',
            'filePhoto' => 'mimes:jpeg,jpg,png'
        ],
            [
                'required' => 'Field :attribute is required'
            ]);

        $brand = $request->get('ddlBrand');
        if($brand == 'other')
            $brand = $request->get('tbBrand');
        $model = $request->get('ddlModel');
        $model1 = $request->get('tbModel');
        $year = $request->get('ddlYear');
        $price = $request->get('nbPrice');
        $km = $request->get('nbKm');
        $desc = $request->get('taDescription');

        //dd($brand, $model, $model1, $year, $price, $km, $desc);
        //dd($request->all());

    }
}