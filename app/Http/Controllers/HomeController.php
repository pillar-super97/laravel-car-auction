<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 3.3.18.
 * Time: 14.21
 */

namespace App\Http\Controllers;


use App\Models\Cars;
use App\Models\Links;

class HomeController
{
    public function renderHome(){
        $links = new Links();
        $res = $links->getAll();
        $gallery = Cars::getGallery();
        $slider = Cars::getSlider();

        if(!session()->has('links')){
            session()->push('links', $res);
        }

        return view('pages.home', ['gallery' => $gallery, 'slider' => $slider]);

    }
}