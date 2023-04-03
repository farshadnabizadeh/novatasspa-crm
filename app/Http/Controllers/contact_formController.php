<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;
use Carbon\Carbon;

class contact_formController extends Controller
{
   public function contact_form(Request $request){
    $dilimiter = null;
    if (str_contains($request->fullname, ',')) {
        $dilimiter = ',';
    }else{
        $dilimiter = ' ';
    }
    if(ContactForm::create([
        'name_surname'=>$request->fullname,
        'phone'=>$request->telephon,
        'country'=>$request->country,
        'email'=>$request->email,
        'form_status_id'=>1,
        'answered_time'=>null,
    ])){
        return response()->json([
            "code"=>200,
            "data"=>"your info recorded successfully",
        ]);
    }else{
        return response()->json([
            "code"=>400,
            "data"=>"operation failed",
        ]);
    }
   }
}
