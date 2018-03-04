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
use Illuminate\Support\Facades\File;

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

        if(array_key_exists("ddlBrand", $request->all())){
            $brandSelector = "ddlBrand";
        }else{
            $brandSelector = "tbBrand";
        }
        if(array_key_exists("ddlModel", $request->all())){
            $modelSelector = "ddlModel";
        }
        else{
            $modelSelector = "tbModel";
        }

        $request->validate([
            $brandSelector => ['required'],
            $modelSelector => ['required'],
            'ddlYear' => ['required'],
            'nbKm' => 'required',
            'nbPrice' => 'required',
            'taDescription' => 'required',
            'filePhoto' => 'required|mimes:jpeg,jpg,png'
        ],
            [
                'required' => 'Field :attribute is required'
            ]);


        if($brandSelector == "tbBrand"){
            $newBrand = $request->get('tbBrand');
            $brand = Cars::insertNewBrand($newBrand);
        }
        else{
            $brand = $request->get("ddlBrand");
        }

        if($modelSelector == "tbModel"){
            $newModel = $request->get("tbModel");
            $model = Cars::insertNewModel($brand, $newModel);
        }
        else{
            $model = $request->get("ddlModel");
        }

        $year = $request->get('ddlYear');
        $price = $request->get('nbPrice');
        $km = $request->get('nbKm');
        $desc = $request->get('taDescription');
        $photo = $request->file('filePhoto');
        $extension = $photo->getClientOriginalExtension();
        $tmp_path = $photo->getPathName();

        $folder = 'images/';
        $file_name = time().".".$extension;
        $new_path = public_path($folder).$file_name;
        try {
            // 4 - Upload slike na server

            File::move($tmp_path, $new_path);

            $res = Cars::insertNewCar($brand, $model, $year, $km, $price, $desc, $folder.$file_name, session()->get('user')[0]->id);
            if(!empty($res))
                return redirect('/')->with('success','Uspesno ste dodali post i sliku!');
        }
        catch(\Illuminate\Database\QueryException $ex){ // greske u upitu
            \Log::error($ex->getMessage());
            return redirect()->back()->with('error','Greska pri dodavanju posta u bazu!');
        }
        catch(\Symfony\Component\HttpFoundation\File\Exception\FileException $ex) { // greske sa fajlom
            \Log::error('Problem sa fajlom!! '.$ex->getMessage());
            return redirect()->back()->with('error','Greska pri dodavanju slike!');
        }
        catch(\ErrorException $ex) {
            \Log::error('Problem sa fajlom!! '.$ex->getMessage());
            return redirect()->back()->with('error','Desila se greska..');
        }

    }
}