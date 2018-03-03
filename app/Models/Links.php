<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 3.3.18.
 * Time: 14.21
 */

namespace App\Models;


use Illuminate\Support\Facades\DB;

class Links
{
    public function __construct()
    {
    }

    public function getAll(){
        $links = DB::table('Links')->get();
        return $links;
    }
}