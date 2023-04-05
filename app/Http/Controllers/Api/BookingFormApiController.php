<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\BookingForm;

class BookingFormApiController extends Controller
{
    public function Booking(Request $request)
    {
        $hammam = null;
        $massage = null;
        $validator = Validator::make($request->all(), [
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'name_surname' => 'required',
            'hammam' => 'array',
            'massage' => 'array',
            'phone' => 'required',
            'country' => 'required',
            'male' => 'required',
            'female' => 'required',
        ]);
        $validator->sometimes('hammam', 'required_without:massage', function (Request $request) {
            return !isset($request->massage);
        });
        $validator->sometimes('massage', 'required_without:hammam', function (Request $request) {
            return !isset($request->hammam);
        });
        if ($request->hammam != "") {
            $hammam = implode(' - ',$request->hammam);
        }
        if ($request->massage != "") {
            $massage =  implode(' - ',$request->massage);
        }
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        } else {
            if (intval(BookingForm::where('reservation_date', $request->reservation_date)->where('reservation_time', $request->reservation_time)->count()) == 0) {
                if (BookingForm::create([
                    'reservation_date' => $request->reservation_date,
                    'reservation_time' => $request->reservation_time,
                    'name_surname' => $request->name_surname,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'massage_package' => $massage,
                    'hammam_package' =>$hammam,
                    'male_pax' => $request->male,
                    'female_pax' => $request->female,
                    'form_status_id' => 1,
                    'answered_time' => null,
                ])) {
                    return response()->json([
                        'code' => 200,
                        'data' => 'Your Information recorded successfully',
                    ]);
                } else {
                    return response()->json([
                        'code' => 400,
                        'data' => 'opration failed',
                    ]);
                }
            } else {
                return response()->json([
                    'code' => 400,
                    'data' => 'This information already recorded',
                ]);
            }
        }
    }
}
