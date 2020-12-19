<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ApiController extends Controller
{
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
