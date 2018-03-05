<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 5.3.18.
 * Time: 21.23
 */

namespace App\Http\Controllers;


use App\Models\Cars;

class MyCarsController
{
    public function render(){
        $cars = Cars::getAllCarsForUser(session()->get('user')[0]->id);
        return view("pages.mycar", ['cars' => $cars]);
    }
}