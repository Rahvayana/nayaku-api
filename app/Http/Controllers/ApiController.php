<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Product;
use App\Models\Tip;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $data['icon']=substr($user->name,0,2);
        $data['name']=$user->name;
        return response()->json([
            'data'=>$data,
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

    public function tips()
    {
        $data=Tip::all();    
        return response($data);
    }
    public function produk()
    {
        $data=Product::all();    
        return response($data);
    }

    public function konsultasi(Request $request)
    {
        
        try{
            $data=DB::table('rules')->select('hasil')
            ->where('kulit',$request->kulit)
            ->where('rule1',json_encode($request->keluhan))->get();
            return response()->json([
                'data'=>$data,
                'keluhan'=>$request->keluhan,
                'keluhan_encode'=>json_encode($request->keluhan),
                'status'=>200
            ],200);
        }catch(Exception $e){
            return response($e,500);
        }
    }

    public function allcomplaint(Request $request)
    {
        $data=DB::table('complaints')->where('kulit',$request->kulit)->get();
        return response($data);
    }

    public function addhistory(Request $request)
    {
        DB::table('histories')->insert([
                'user_id' => $request->id_user,
                'treatment' => $request->perawatan,
                'complaint' => 1,
                'type' => $request->kulit,
                'hasil' => $request->produk,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            return response()->json([
                'status'=>200,
                'message'=>'Sukses'
            ]);
    }

    public function history(Request $request)
    {
        $data=DB::table('histories')->where('user_id',$request->id_user)->get();
        return response($data);
    }
}
