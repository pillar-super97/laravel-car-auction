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

    public function renderLogin(){
        return view("pages.login");
    }
    public function renderRegister(){
        return view('pages.register');
    }

    public function login(Request $req){
        $req->validate([
            'tbUsername' => ['required'],
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

    public function register(Request $req){
        $req->validate([
            'tbFirstName' => ['required', 'alpha'],
            'tbLastName' => ['required', 'alpha'],
            'tbUsername' => ['required'],
            'tbPassword' => ['required'],
            'tbEmail' => ['required'],
        ],
            [
                'required' => 'Field :attribute is required'
            ]);

        $name = $req->get('tbFirstName');
        $last_name = $req->get('tbLastName');
        $username = $req->get('tbUsername');
        $password = $req->get('tbPassword');
        $email = $req->get('tbEmail');

        $user = new User();
        $user->setFirstName($name);
        $user->setLastName($last_name);
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);

        $id = $user->insertNewUser();
        if (!empty($id))
            return redirect()->back()->with('msg', 'Uspesno ste se registrovali');
        else
            return redirect()->back()->with('msg', 'Registracija nije uspela');

    }

    public function logout(Request $request){
        $request->session()->forget('user');
        $request->session()->flush();
        return redirect('/');
    }
}