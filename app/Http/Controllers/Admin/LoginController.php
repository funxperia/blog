<?php

namespace App\Http\Controllers\Admin;


use App\Http\Model\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;

require_once 'resources/org/code/Code.class.php';

class LoginController extends CommonController
{
    public function login(){
        if($input = Input::all()){
            $code = new \Code;
            $code1 = $code -> get();
            if(strtoupper($input['code']) != $code1){
                return back() -> with('msg','验证码错误');
            }
            $user = User::first();
            if($user -> user_name == $input['user_name'] && Crypt::decrypt($user -> user_pass) == $input['user_pass']){
                session(['user' => $user]);
                dd(session('user'));
            } else{
                return back() -> with('msg','用户名或密码错误');
            }
        }else{
            return view('admin.login');
        }
    }
    public function code(){
        $code = new \Code;
        $code -> make();
    }
}
