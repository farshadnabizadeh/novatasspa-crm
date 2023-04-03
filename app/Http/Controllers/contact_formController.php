<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ContactForm;
use Illuminate\Support\Facades\Validator;

class contact_formController extends Controller
{
    public function contact_form(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_surname' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return 'inputs can not be empty';
        } else {
            if (ContactForm::create([
                'name_surname' => str_contains($request->fullname, ',') ? str_replace(',', ' ', $request->fullname) : $request->fullname,
                'phone' => $request->telephon,
                'country' => $request->country,
                'email' => $request->email,
                'form_status_id' => 1,
                'answered_time' => null,
            ])) {
                return response()->json([
                    "code" => 200,
                    "data" => "your info recorded successfully",
                ]);
            } else {
                return response()->json([
                    "code" => 400,
                    "data" => "operation failed",
                ]);
            }
        }
    }
}
