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

        $validator = Validator::make($request->all(), [
            'reservation_date' => 'required',
            'reservation_time' => 'required',
            'name_surname' => 'required',
            'phone' => 'required',
            'country' => 'required',
            'massage' => '',
            'hammam' => 'required',
            'male' => 'required',
            'female' => 'required',
        ]);
        if ($validator->fails()) {
            return 'inputs can not be empty';
        } else {
            if (intval(BookingForm::where('reservation_date', $request->reservation_date)->where('reservation_time', $request->reservation_time)->count()) == 0) {
                if (BookingForm::create([
                    'reservation_date' => $request->reservation_date,
                    'reservation_time' => $request->reservation_time,
                    'name_surname' => str_contains($request->name_surname, ',') ? str_replace(',', ' ', $request->name_surname) : $request->name_surname,
                    'phone' => $request->phone,
                    'country' => $request->country,
                    'massage_package' => str_replace(',', '-', trim(trim($request->massage, '['), ']')),
                    'hammam_package' => str_replace(',', '-', trim(trim($request->hammam, '['), ']')),
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
