<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ApiController extends Controller
{


    public function login(Request $request)
    {
        $user=User::where('email',$request->email)->first();
        if ($user && Hash::check($request->password, $user->password)&&$user->is_user==1) {
            return response()->json([
                'data'=>$user->id,
                'status'=>200,
                'message'=>'Sukses'
            ]);
        }else{
            return response()->json([
                'status'=>500,
                'message'=>'Gagal Login, Cek Email atau Password'
            ]);
        }
    }

    public function register(Request $request)
    {
       try{
        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->no_hp=$request->no_hp;
        $user->password=bcrypt($request->password);
        $user->gender=$request->gender;
        $user->usia=$request->usia;
        $user->is_user=1;
        $user->role='user';
        $user->alamat=$request->alamat;
        $user->save();
        return response()->json([
             'data'=>$user->id,
             'status'=>200,
             'message'=>'Sukses'
         ]);
       }catch(Exception $e){
        return response()->json([
            'status'=>500,
            'message'=>$e->getMessage(),
        ]);
       }
    }

    public function home(Request $request)
    {
        $id=$request->id;
        $user=User::find($id);
        return response()->json([
            'data'=>substr($user->name,0,2),
            'status'=>200,
            'message'=>'Sukses'
        ]);
    }

    public function tentang()
    {
        $data=Contact::all();    
        return response()->json([
            'data'=>$data,
            'status'=>200,
            'message'=>'Sukses'
        ]);
    }
}
