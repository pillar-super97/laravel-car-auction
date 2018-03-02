<?php
/**
 * Created by IntelliJ IDEA.
 * User: kica
 * Date: 27.2.18.
 * Time: 20.51
 */

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController
{

    public function render(){
        return view("pages.login");
    }

    public function login(Request $req){
        $req->validate([
            'tbUsername' => ['required', 'alpha'],
            'tbPassword' => ['required']
        ],
            [
                'required' => 'Field :attribute is required'
            ]);

        $username = $req->get('tbUsername');
        $password = $req->get('tbPassword');

        $user = new User();
        $user->setUsername($username);
        $user->setPassword($password);

        $res = $user->loginUser();

        if(!empty($res)){
            $req->session()->push('user', $res);
            return redirect('/');
        }
        else{
            return redirect('/login')->with('error','Niste registrovani!');
        }
    }

    public function logout(Request $request){
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect('/');
    }
}